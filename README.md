# Research Analytics ETL Pipeline

End-to-end data engineering solution for research analytics data processing and forecasting.

## Overview

This project demonstrates a production-grade ETL pipeline built to process research analytics data from API sources. The solution implements two core data engineering workflows:

1. **Analyst Scoring Data Pipeline** - Processes vendor evaluation data from research APIs into a dimensional model for BI analytics
2. **Emissions Forecasting System** - Generates predictive models for corporate carbon emission trajectories using historical API data

The implementation showcases modern data engineering practices including dimensional modeling, dual-language implementation (Python/SQL), and scalable ETL architecture.

## Project Structure

```
research-company-data-engineering/
├── src/
│   ├── solution_realistic.py      # Python ETL pipeline
│   └── solution.sql               # PostgreSQL implementation
├── outputs/
│   ├── part1_output.xlsx          # Processed vendor analytics
│   └── part2_output.xlsx          # Emission forecasts
├── docs/
│   └── TASK_MAPPING.md           # Technical documentation
└── requirements.txt               # Python dependencies
```

## Technical Stack

- Python 3.9+ (pandas, numpy, openpyxl)
- PostgreSQL 13+
- SQL (dimensional modeling, window functions, CTEs)

## Pipeline 1: Vendor Analytics Processing

**Data Source**: Research company API endpoint providing vendor evaluation metrics

**Challenge**: API returns nested hierarchical data (evaluation axes → criteria → sub-criteria) requiring complex parsing and aggregation before analysis.

**Solution**: 
- Extract vendor scoring data from API responses
- Parse hierarchical JSON/XML structure into normalized format
- Calculate weighted scores from sub-criteria measurements
- Transform into star schema dimensional model
- Output BI-ready datasets for visualization tools

**Output Metrics**:
- 18 vendors processed
- 32 evaluation criteria across 2 primary axes
- 1,332 fact records in dimensional model
- 5 analytical views (2 aggregate + 3 dimensional tables)

### Data Model

Star schema optimized for analytical queries:

```
Dim_Vendors (vendor_id, vendor_name)
Dim_Axes (axis_id, axis_name)
Dim_Criteria (criteria_id, axis_id, criteria_number, criteria_name)
Fact_Scores (vendor_id, criteria_id, axis_id, score)
```

**Business Applications:**
- Vendor competitive positioning analysis
- Market trend identification
- Technology evaluation and comparison
- Strategic sourcing decisions

## Pipeline 2: Carbon Emissions Forecasting

**Data Source**: Environmental data API providing corporate emissions reporting and targets

**Challenge**: Generate accurate emission projections to 2050 based on corporate net-zero commitments, identify performance gaps, and recalculate trajectories for off-track entities.

**Solution**:
- Ingest baseline and target data from API endpoints
- Apply linear interpolation forecasting (baseline → interim → net zero)
- Integrate historical actuals from time-series API
- Calculate overshoot scenarios for entities missing targets
- Generate revised trajectory projections

**Output Metrics**:
- 2,589 projection records (forecasted emissions to 2050)
- 604 historical records (2016-2022 actuals from API)
- 753 overshoot scenarios (revised trajectories)

### Forecasting Algorithm

Two-phase linear interpolation for entities with interim targets:

```
Phase 1: Baseline → Interim Target
  annual_reduction = (baseline_emissions - interim_emissions) / years_to_interim
  
Phase 2: Interim → Net Zero
  annual_reduction = (interim_emissions - net_zero_emissions) / years_to_netzero
  
Post Net-Zero: Maintained at 0.01 × baseline (99% reduction threshold)
```

### Overshoot Calculation Logic

For entities exceeding projected emissions:
- Identify variance between actual vs. projected (API comparison)
- Maintain organizational reduction rate (capacity constraint assumption)
- Calculate implied new net-zero year
- Generate revised trajectory from current state

**Research Applications:**
- Corporate climate commitment tracking
- Sectoral emission trend forecasting
- Climate risk assessment modeling
- Policy impact analysis

## Getting Started

### Prerequisites

```bash
python --version  # 3.9 or higher
psql --version    # Optional, for SQL implementation
```

### Installation

```bash
git clone https://github.com/aymanfoundry/research-company-data-engineering.git
cd research-company-data-engineering
pip install -r requirements.txt
```

### Execute Pipeline

```bash
python src/solution_realistic.py
```

Outputs generated:
- `part1_output.xlsx` - Vendor analytics dimensional model
- `part2_output.xlsx` - Emission forecasts and projections

### PostgreSQL Deployment (Optional)

```sql
CREATE DATABASE research_analytics;
\c research_analytics
\i src/solution.sql
```

## Architecture

**Dual Implementation Strategy:**

This project implements identical functionality in both Python and PostgreSQL to demonstrate:

- **Python Layer**: API integration, data extraction, complex transformations, orchestration
- **SQL Layer**: Set-based operations, dimensional storage, analytical queries, BI integration

**Production Architecture:**
1. Python handles API consumption and ETL orchestration (Airflow/Prefect)
2. PostgreSQL provides dimensional model persistence and query layer
3. BI tools (Tableau/Power BI) connect directly to database views
4. API rate limiting and caching handled at Python layer

## Output Specifications

### Pipeline 1: Vendor Analytics

File: `part1_output.xlsx`

**Sheets**:
1. Axis Scores (Quadrant) - Aggregate metrics for visualization
2. Criteria Detail - Granular data for drill-down analysis
3. Dim_Vendors - Vendor dimension table
4. Dim_Criteria - Criteria dimension table
5. Fact_Scores - Fact table containing measurements

### Pipeline 2: Emissions Forecasts

File: `part2_output.xlsx`

**Schema**: Lookup, Company ID, Scope, Type, Year, Emissions (tCO2e)

**Record Types**:
- Projection - Forecasts based on declared targets
- Actual - Historical data from API time-series
- Overshoot Projection - Revised forecasts for off-track entities

## Technical Decisions

**Star Schema Design**
- Industry-standard pattern for OLAP workloads
- Optimized for BI tool query patterns
- Simple join paths for ad-hoc analysis
- Extensible for historical tracking (SCD Type 2)

**Linear Interpolation Model**
- Transparent assumptions for stakeholder communication
- Computationally efficient for large datasets
- Provides baseline for model comparison
- Note: Real-world emissions follow non-linear curves; linear model serves as conservative estimate

**Dual Python/SQL Implementation**
- Demonstrates polyglot data engineering capabilities
- Shows understanding of tool-specific strengths
- Reflects real-world production architecture patterns

## Development Notes

**Development Timeline**: March 18-20, 2025

**Current Limitations**:
- Linear interpolation model (production would use exponential decay)
- Basic error handling (production requires comprehensive exception management)
- SQL implementation conceptual (not execution-tested against live database)
- Unit test coverage not included

**Production Enhancements Roadmap**:
- Comprehensive error handling and retry logic
- Unit and integration test suites (pytest, pytest-mock)
- Data quality validation framework (Great Expectations)
- CI/CD pipeline (GitHub Actions)
- Containerization (Docker, docker-compose)
- Observability (Prometheus, Grafana)
- API rate limiting and caching strategy

## Extensibility

- Implement historical comparison with SCD Type 2 dimensions
- Add non-linear forecasting models (exponential, logistic decay)
- Build interactive dashboard (Streamlit, Plotly Dash)
- Create REST API wrapper (FastAPI)
- Implement incremental load patterns for API updates
- Add dbt for SQL transformation orchestration
- Create Airflow DAGs for production scheduling

## Documentation

- [Technical Specification](docs/TASK_MAPPING.md) - Detailed requirements and implementation
- [Python Pipeline](src/solution_realistic.py) - Annotated ETL code
- [SQL Schema](src/solution.sql) - Database DDL and transformations

## License

MIT License - see LICENSE file for details

## Author

Ayman Hassan
- GitHub: [github.com/aymanfoundry](https://github.com/aymanfoundry)
- LinkedIn: [linkedin.com/in/aymanahassan2](https://www.linkedin.com/in/aymanahassan2)

---

Independent project demonstrating ETL pipeline architecture, dimensional modeling, and production data engineering practices for research analytics applications.
