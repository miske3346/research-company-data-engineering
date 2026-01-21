# COMPLETE TASK-TO-FILE MAPPING
## Research Company Data Engineering Project

---

## 📋 PART 1: GREEN QUADRANT

### **Task 1.a) Design a data pipeline to ingest the raw file, cleanse any errors, and produce a BI (Business Intelligence) ready data output. Please provide details the schema you would use to arrange the data.**

**YOUR DELIVERABLES:**

**Code:**
- ✅ `solution_realistic.py` (Lines 18-199) - Class: `GreenQuadrantProcessor`
  - Method: `load_data()` - Ingests raw Excel
  - Method: `parse_and_clean()` - Parses hierarchy, calculates weighted scores
  - Method: `create_dimensional_model()` - Creates star schema
  - Method: `generate_outputs()` - Creates BI-ready Excel output

- ✅ `research-analytics_solution.sql` (Lines 16-175) - PostgreSQL approach
  - CREATE TABLE statements for staging + star schema
  - INSERT...SELECT for dimension population
  - CREATE VIEW for BI queries

**Output:**
- ✅ `part1_output.xlsx` - 5 sheets:
  - "Axis Scores (Quadrant)" - Data for scatter plot
  - "Criteria Detail" - Drill-down data
  - "Dim_Vendors", "Dim_Criteria", "Fact_Scores" - Star schema tables

**Documentation:**
- ✅ `Technical Documentation` - Section "Task 1.a)" 
  - Shows Python approach
  - Shows SQL approach
  - Explains star schema decision

**Schema Details:**
- Star schema with 3 dimensions + 1 fact table
- Dim_Vendors (18 vendors)
- Dim_Criteria (32 criteria)
- Fact_Scores (1,332 measurements)

---

### **Task 1.b) Design a process to ingest data from prior GQ reports for the same software vendors and produce a quadrant chart showing the change in their score from the historic report to the most recent.**

**YOUR DELIVERABLES:**

**Code:**
- ✅ `solution_realistic.py` (Lines 200-215) - Framework code (not executed, no historic data)
- ✅ `research-analytics_solution.sql` (Lines 177-215) - Design with Dim_Time table and SQL query examples

**Documentation:**
- ✅ `Technical Documentation` - Section "Task 1.b)"
  - Design approach (add time dimension)
  - Python approach (pandas merges)
  - SQL approach (window functions with LAG)

**Note:** This is a DESIGN task (no historic data provided to execute)

---

## 📋 PART 2: CARBON EMISSIONS FORECASTING

### **Task 2.a) Design a data pipeline to cleanse the raw data and produce a forecast for yearly carbon emissions from Baseline year to 2050. The forecast should follow a linear yearly decrease between baseline emissions and both interim target years, and ultimate net zero year.**

**YOUR DELIVERABLES:**

**Code:**
- ✅ `solution_realistic.py` (Lines 217-380) - Class: `CarbonForecastProcessor`
  - Method: `load_data()` - Loads both Excel sheets
  - Method: `prepare_data()` - Applies business rules
  - Method: `generate_forecasts()` - **THIS IS THE CORE - Linear interpolation**
    - Two-phase: baseline → interim → net zero
    - Single-phase: baseline → net zero
    - Post net zero: constant at 0.01 × baseline

- ✅ `research-analytics_solution.sql` (Lines 217-332) - PostgreSQL approach
  - Recursive CTE to generate year series
  - CASE statement for linear interpolation logic

**Output:**
- ✅ `part2_output.xlsx` - Records with Type = **"Projection"**
  - 2,589 projection records
  - Years: baseline → 2050
  - Linear decrease implemented

**Documentation:**
- ✅ `Technical Documentation` - Section "Task 2.a)"
  - Explains two-phase math
  - Python approach (loops + calculations)
  - SQL approach (recursive CTE)

---

### **Task 2.b) Alongside this forecast data, produce 'actual data' to display the distance that each firm is from their current target.**

**YOUR DELIVERABLES:**

**Code:**
- ✅ `solution_realistic.py` (Lines 381-410) - Method: `add_actuals()`
  - Loads historic emissions (2016-2022)
  - Reshapes from wide to long
  - Adds to same dataset as projections

- ✅ `research-analytics_solution.sql` (Lines 334-370) - PostgreSQL approach
  - INSERT actuals into same table
  - CREATE VIEW for gap analysis (actual - forecast)

**Output:**
- ✅ `part2_output.xlsx` - **SAME FILE** as 2.a, now includes Type = **"Actual"**
  - 604 actual records (2016-2022)
  - Merged with projections for comparison

**Documentation:**
- ✅ `Technical Documentation` - Section "Task 2.b)"
  - Python approach (reshape and append)
  - SQL approach (INSERT + JOIN for gaps)

---

### **Task 2.c) Produce an 'implied overshoot' forecast which plots the projected net zero year for corporates whose actual emissions are higher than forecast emissions for the most recent year.**

**YOUR DELIVERABLES:**

**Code:**
- ✅ `solution_realistic.py` (Lines 411-475) - Method: `calculate_overshoot()`
  - Identifies companies where actual > forecast
  - Calculates implied new net zero year
  - Maintains same reduction rate
  - Generates new trajectory

- ✅ `research-analytics_solution.sql` (Lines 372-420) - PostgreSQL approach
  - CTE to find off-track companies
  - Window functions for latest actuals

**Output:**
- ✅ `part2_output.xlsx` - **SAME FILE**, now includes Type = **"Overshoot Projection"**
  - 753 overshoot projection records
  - Shows recalculated trajectories for companies behind schedule

**Documentation:**
- ✅ `Technical Documentation` - Section "Task 2.c)"
  - Overshoot logic explained
  - Why maintain same reduction rate
  - Python vs SQL trade-offs

---

## 📊 SUMMARY TABLE

| Task | What It Asks For | Your Code | Your Output | Documentation |
|------|------------------|-----------|-------------|---------------|
| **Part 1.a** | Pipeline + BI output + Schema | `solution_realistic.py` lines 18-199<br>`research-analytics_solution.sql` lines 16-175 | `part1_output.xlsx` (all 5 sheets) | `Technical Documentation` Task 1.a section |
| **Part 1.b** | Historical comparison design | `solution_realistic.py` lines 200-215<br>`research-analytics_solution.sql` lines 177-215 | Design only (no data) | `Technical Documentation` Task 1.b section |
| **Part 2.a** | Forecast generation | `solution_realistic.py` lines 217-380<br>`research-analytics_solution.sql` lines 217-332 | `part2_output.xlsx` (Projection records) | `Technical Documentation` Task 2.a section |
| **Part 2.b** | Add actual emissions | `solution_realistic.py` lines 381-410<br>`research-analytics_solution.sql` lines 334-370 | `part2_output.xlsx` (Actual records added) | `Technical Documentation` Task 2.b section |
| **Part 2.c** | Overshoot projections | `solution_realistic.py` lines 411-475<br>`research-analytics_solution.sql` lines 372-420 | `part2_output.xlsx` (Overshoot records added) | `Technical Documentation` Task 2.c section |

---

## 🎯 KEY TECHNICAL POINTS

### **Part 1.a - They'll ask: "How did you build the pipeline?"**
**Your answer:**
"I built a 5-stage pipeline in Python. Stage 1 loads the raw Excel, Stage 2 parses the hierarchy and calculates weighted scores - that was the tricky part because axes, criteria, and weights are all mixed together. Stage 3 reshapes to long format, Stage 4 creates the star schema, and Stage 5 outputs to Excel. I also showed how I'd do this in SQL - Python parses the Excel, loads to staging, then SQL does the transformations."

### **Part 2.a - They'll ask: "Explain the linear interpolation"**
**Your answer:**
"For companies with interim targets, it's two-phase. Phase 1: linear decrease from baseline to interim emissions over that time period. Phase 2: linear decrease from interim to net zero. For companies without interim targets, it's a single linear path from baseline to net zero. After net zero year, emissions stay constant at 0.01 times baseline - that's 99% reduction. I calculated this year-by-year in Python, but I also showed how you'd do it in SQL with a recursive CTE."

### **Part 2.c - They'll ask: "Why did you maintain the same reduction rate for overshoot?"**
**Your answer:**
"A company's reduction capacity is fairly fixed - it depends on their tech, budget, operations. If they're behind now, they'll probably keep the same pace, just shifted in time. This shows the real consequence of being off-track - they'll miss their net zero target by X years. It's more realistic than assuming they'll suddenly accelerate."

---

## ✅ FILES TO SUBMIT

1. `solution_realistic.py` - Has ALL the code for all tasks
2. `research-analytics_solution.sql` - Shows SQL approach for all tasks
3. `part1_output.xlsx` - Answers Part 1.a
4. `part2_output.xlsx` - Answers Part 2.a, 2.b, AND 2.c (all in one file)
5. `README.docx` - Overview
6. `Technical Documentation` - Your prep notes with Python + SQL for each task

---

**EVERYTHING IS MAPPED AND READY TO SUBMIT** ✅
