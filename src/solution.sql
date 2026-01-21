-- Research Company ETL Pipeline - PostgreSQL Implementation
-- Date: March 20, 2025
-- 
-- This shows how I'd implement the same solution using PostgreSQL instead of pure Python.
-- The approach: Python handles Excel parsing → load to staging → SQL does transformations
--
-- Note: Didn't have a PG instance running to test this but the SQL should work.
--       The Python script (solution_realistic.py) is the working version.

-- ==============================================================================
-- PART 1: GREEN QUADRANT - DIMENSIONAL MODEL
-- ==============================================================================

-- Drop existing tables if they exist
DROP TABLE IF EXISTS fact_scores CASCADE;
DROP TABLE IF EXISTS dim_criteria CASCADE;
DROP TABLE IF EXISTS dim_axes CASCADE;
DROP TABLE IF EXISTS dim_vendors CASCADE;
DROP TABLE IF EXISTS staging_gq CASCADE;

-- Staging table for raw parsed data from Excel
CREATE TABLE staging_gq (
    vendor_name VARCHAR(100),
    axis_name VARCHAR(50),
    criteria_number NUMERIC,
    criteria_name VARCHAR(200),
    score NUMERIC(5,2),
    load_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Dimension: Vendors
CREATE TABLE dim_vendors (
    vendor_id SERIAL PRIMARY KEY,
    vendor_name VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Dimension: Axes (Momentum, Capabilities)
CREATE TABLE dim_axes (
    axis_id SERIAL PRIMARY KEY,
    axis_name VARCHAR(50) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Dimension: Criteria (linked to axes)
CREATE TABLE dim_criteria (
    criteria_id SERIAL PRIMARY KEY,
    axis_id INTEGER REFERENCES dim_axes(axis_id),
    criteria_number NUMERIC,
    criteria_name VARCHAR(200) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Fact: Scores (measurements)
CREATE TABLE fact_scores (
    vendor_id INTEGER REFERENCES dim_vendors(vendor_id),
    criteria_id INTEGER REFERENCES dim_criteria(criteria_id),
    axis_id INTEGER REFERENCES dim_axes(axis_id),
    score NUMERIC(5,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (vendor_id, criteria_id)
);

-- Indexes for query performance
CREATE INDEX idx_fact_vendor ON fact_scores(vendor_id);
CREATE INDEX idx_fact_criteria ON fact_scores(criteria_id);
CREATE INDEX idx_fact_axis ON fact_scores(axis_id);
CREATE INDEX idx_criteria_axis ON dim_criteria(axis_id);

-- Transform staging data into dimensional model
-- Step 1: Populate dimensions

INSERT INTO dim_axes (axis_name)
SELECT DISTINCT axis_name
FROM staging_gq
WHERE axis_name IS NOT NULL;

INSERT INTO dim_vendors (vendor_name)
SELECT DISTINCT vendor_name
FROM staging_gq
WHERE vendor_name IS NOT NULL;

INSERT INTO dim_criteria (axis_id, criteria_number, criteria_name)
SELECT DISTINCT
    a.axis_id,
    s.criteria_number,
    s.criteria_name
FROM staging_gq s
JOIN dim_axes a ON s.axis_name = a.axis_name
WHERE s.criteria_name IS NOT NULL;

-- Step 2: Populate facts
INSERT INTO fact_scores (vendor_id, criteria_id, axis_id, score)
SELECT DISTINCT
    v.vendor_id,
    c.criteria_id,
    a.axis_id,
    s.score
FROM staging_gq s
JOIN dim_vendors v ON s.vendor_name = v.vendor_name
JOIN dim_axes a ON s.axis_name = a.axis_name
JOIN dim_criteria c ON c.axis_id = a.axis_id 
    AND c.criteria_number = s.criteria_number
WHERE s.score IS NOT NULL;

-- BI Views for Tableau/Power BI
-- View 1: Axis scores for quadrant chart
CREATE OR REPLACE VIEW vw_quadrant_scores AS
SELECT 
    v.vendor_name,
    a.axis_name,
    AVG(f.score) as axis_score
FROM fact_scores f
JOIN dim_vendors v ON f.vendor_id = v.vendor_id
JOIN dim_axes a ON f.axis_id = a.axis_id
GROUP BY v.vendor_name, a.axis_name;

-- View 2: Criteria detail for drill-down
CREATE OR REPLACE VIEW vw_criteria_detail AS
SELECT 
    v.vendor_name,
    a.axis_name,
    c.criteria_name,
    c.criteria_number,
    f.score
FROM fact_scores f
JOIN dim_vendors v ON f.vendor_id = v.vendor_id
JOIN dim_axes a ON f.axis_id = a.axis_id
JOIN dim_criteria c ON f.criteria_id = c.criteria_id
ORDER BY v.vendor_name, a.axis_name, c.criteria_number;

-- Query examples:
-- Get quadrant data for chart:
-- SELECT * FROM vw_quadrant_scores;

-- Drill down to specific vendor:
-- SELECT * FROM vw_criteria_detail WHERE vendor_name = 'COMPANY A';

-- ==============================================================================
-- PART 1B: HISTORICAL COMPARISON (Design)
-- ==============================================================================

-- To add historical tracking, extend with time dimension:

CREATE TABLE dim_time (
    time_id SERIAL PRIMARY KEY,
    report_year INTEGER NOT NULL,
    report_quarter INTEGER,
    report_name VARCHAR(100),
    report_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Modify fact table to include time dimension
ALTER TABLE fact_scores ADD COLUMN time_id INTEGER REFERENCES dim_time(time_id);

-- Query to show movement between reports:
-- WITH current_scores AS (
--     SELECT vendor_id, axis_id, score, time_id
--     FROM fact_scores
--     WHERE time_id = (SELECT MAX(time_id) FROM fact_scores)
-- ),
-- prior_scores AS (
--     SELECT vendor_id, axis_id, score, time_id
--     FROM fact_scores
--     WHERE time_id = (SELECT MAX(time_id) - 1 FROM fact_scores)
-- )
-- SELECT 
--     v.vendor_name,
--     a.axis_name,
--     c.score as current_score,
--     p.score as prior_score,
--     c.score - p.score as movement,
--     CASE 
--         WHEN c.score > p.score THEN 'Improved'
--         WHEN c.score < p.score THEN 'Declined'
--         ELSE 'No Change'
--     END as direction
-- FROM current_scores c
-- JOIN prior_scores p ON c.vendor_id = p.vendor_id AND c.axis_id = p.axis_id
-- JOIN dim_vendors v ON c.vendor_id = v.vendor_id
-- JOIN dim_axes a ON c.axis_id = a.axis_id;


-- ==============================================================================
-- PART 2: CARBON EMISSIONS FORECASTING
-- ==============================================================================

DROP TABLE IF EXISTS emissions_forecasts CASCADE;
DROP TABLE IF EXISTS emissions_targets CASCADE;

-- Targets table (from Excel)
CREATE TABLE emissions_targets (
    company_id VARCHAR(10),
    scope VARCHAR(10),
    baseline_year INTEGER,
    baseline_emissions NUMERIC(12,2),
    nz_target_year INTEGER,
    interim_target_year INTEGER,
    interim_target_pct NUMERIC(4,3),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (company_id, scope)
);

-- Forecasts table (stores actuals, projections, overshoot)
CREATE TABLE emissions_forecasts (
    lookup VARCHAR(50),
    company_id VARCHAR(10),
    scope VARCHAR(10),
    forecast_type VARCHAR(30),  -- 'Actual', 'Projection', 'Overshoot Projection'
    year INTEGER,
    emissions NUMERIC(12,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (company_id, scope, forecast_type, year)
);

CREATE INDEX idx_forecasts_company ON emissions_forecasts(company_id);
CREATE INDEX idx_forecasts_type ON emissions_forecasts(forecast_type);
CREATE INDEX idx_forecasts_year ON emissions_forecasts(year);

-- ==============================================================================
-- PART 2A: GENERATE FORECASTS USING RECURSIVE CTE
-- ==============================================================================

-- This is the SQL way to generate year-by-year forecasts
-- Uses recursive CTE to create year series, then CASE for linear interpolation

WITH RECURSIVE year_series AS (
    -- Base case: start with baseline years
    SELECT 
        company_id,
        scope,
        baseline_year as year,
        baseline_emissions,
        nz_target_year,
        interim_target_year,
        interim_target_pct
    FROM emissions_targets
    WHERE baseline_year IS NOT NULL
    
    UNION ALL
    
    -- Recursive case: add years up to 2050
    SELECT 
        company_id,
        scope,
        year + 1,
        baseline_emissions,
        nz_target_year,
        interim_target_year,
        interim_target_pct
    FROM year_series
    WHERE year < 2050
),
forecasts AS (
    SELECT 
        company_id || scope as lookup,
        company_id,
        scope,
        'Projection' as forecast_type,
        year,
        -- Linear interpolation logic with two phases
        CASE 
            -- Phase 1: Baseline to Interim (if interim exists)
            WHEN interim_target_year IS NOT NULL 
                 AND interim_target_pct IS NOT NULL
                 AND year <= interim_target_year THEN
                baseline_emissions - 
                ((baseline_emissions - (baseline_emissions * (1 - interim_target_pct))) / 
                 NULLIF(interim_target_year - year, 0)) * (year - year)
            
            -- Phase 2: Interim to Net Zero (if interim exists)
            WHEN interim_target_year IS NOT NULL 
                 AND interim_target_pct IS NOT NULL
                 AND year > interim_target_year 
                 AND year <= nz_target_year THEN
                (baseline_emissions * (1 - interim_target_pct)) -
                (((baseline_emissions * (1 - interim_target_pct)) - (baseline_emissions * 0.01)) / 
                 NULLIF(nz_target_year - interim_target_year, 0)) * (year - interim_target_year)
            
            -- Single phase: Baseline to Net Zero (no interim)
            WHEN (interim_target_year IS NULL OR interim_target_pct IS NULL)
                 AND year <= nz_target_year THEN
                baseline_emissions - 
                ((baseline_emissions - (baseline_emissions * 0.01)) / 
                 NULLIF(nz_target_year - year, 0)) * (year - year)
            
            -- Post net zero: maintain at 1% of baseline
            WHEN year > nz_target_year THEN
                baseline_emissions * 0.01
            
            ELSE baseline_emissions
        END as emissions
    FROM year_series
)
INSERT INTO emissions_forecasts (lookup, company_id, scope, forecast_type, year, emissions)
SELECT 
    lookup, 
    company_id, 
    scope, 
    forecast_type, 
    year,
    GREATEST(emissions, baseline_emissions * 0.01) as emissions
FROM forecasts
WHERE emissions IS NOT NULL;

-- Note: The above is conceptual - would need to be refined based on actual data
-- In practice, might be easier to do this in Python and just load results to PG


-- ==============================================================================
-- PART 2B: ADD ACTUAL EMISSIONS
-- ==============================================================================

-- Assuming actuals have been loaded to a staging table from the Excel file
-- CREATE TABLE staging_actuals (company_id, scope, year_2016, year_2017, ...);

-- Would need to unpivot/melt the year columns, then insert:
-- INSERT INTO emissions_forecasts (lookup, company_id, scope, forecast_type, year, emissions)
-- SELECT 
--     company_id || scope,
--     company_id,
--     scope,
--     'Actual',
--     year,
--     emissions
-- FROM staging_actuals_unpivoted;

-- Query to compare actuals vs projections (gap analysis):
CREATE OR REPLACE VIEW vw_emissions_gap AS
SELECT 
    a.company_id,
    a.scope,
    a.year,
    a.emissions as actual_emissions,
    p.emissions as projected_emissions,
    a.emissions - p.emissions as gap,
    CASE 
        WHEN a.emissions <= p.emissions THEN 'On Track'
        WHEN a.emissions > p.emissions THEN 'Behind Target'
    END as status
FROM emissions_forecasts a
JOIN emissions_forecasts p 
    ON a.company_id = p.company_id 
    AND a.scope = p.scope 
    AND a.year = p.year
WHERE a.forecast_type = 'Actual'
  AND p.forecast_type = 'Projection';


-- ==============================================================================
-- PART 2C: OVERSHOOT CALCULATIONS
-- ==============================================================================

-- Find companies where most recent actual > forecast (they're behind)
WITH latest_actual AS (
    SELECT 
        company_id,
        scope,
        MAX(year) as latest_year,
        MAX(year) FILTER (WHERE year = MAX(year)) as max_year
    FROM emissions_forecasts
    WHERE forecast_type = 'Actual'
    GROUP BY company_id, scope
),
off_track_companies AS (
    SELECT 
        la.company_id,
        la.scope,
        la.latest_year,
        a.emissions as actual_emissions,
        p.emissions as forecast_emissions
    FROM latest_actual la
    JOIN emissions_forecasts a 
        ON la.company_id = a.company_id 
        AND la.scope = a.scope 
        AND la.latest_year = a.year
        AND a.forecast_type = 'Actual'
    JOIN emissions_forecasts p 
        ON la.company_id = p.company_id 
        AND la.scope = p.scope 
        AND la.latest_year = p.year
        AND p.forecast_type = 'Projection'
    WHERE a.emissions > p.emissions  -- Behind schedule
)
SELECT 
    company_id,
    scope,
    latest_year,
    actual_emissions,
    forecast_emissions,
    actual_emissions - forecast_emissions as behind_by
FROM off_track_companies;

-- To calculate the implied new net zero year, would need to:
-- 1. Get the original annual reduction rate from targets
-- 2. Calculate years_needed = (current_actual - nz_emissions) / annual_reduction
-- 3. implied_nz_year = current_year + years_needed
-- 4. Generate new trajectory using recursive CTE similar to above

-- This gets complex in pure SQL, so the Python implementation handles this better


-- ==============================================================================
-- USEFUL QUERIES
-- ==============================================================================

-- Summary: Count of forecasts by type
-- SELECT forecast_type, COUNT(*) 
-- FROM emissions_forecasts 
-- GROUP BY forecast_type;

-- Companies furthest behind their targets
-- SELECT company_id, scope, SUM(gap) as total_gap
-- FROM vw_emissions_gap
-- GROUP BY company_id, scope
-- ORDER BY total_gap DESC
-- LIMIT 10;

-- Year-by-year emissions for specific company
-- SELECT year, forecast_type, emissions
-- FROM emissions_forecasts
-- WHERE company_id = 'V000001' AND scope = 'Scope 1'
-- ORDER BY year, forecast_type;
