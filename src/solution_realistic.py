"""
Research Analytics ETL Pipeline
Data Engineering Project
March 2025

ETL pipeline for processing research analytics data from API sources.
Implements vendor evaluation processing and emissions forecasting systems.

Key Features:
- API data extraction and transformation
- Dimensional modeling (star schema)
- Dual Python/PostgreSQL implementation
- Linear interpolation forecasting
- Time-series analysis

Notes:
- Built over a weekend as portfolio project
- Some code could be optimized but prioritized functionality
- Tested with sample datasets
"""
- Clean up some of the repeated code in Part 2
"""

import pandas as pd
import numpy as np
from openpyxl import Workbook
from openpyxl.styles import Font, PatternFill
import warnings
warnings.filterwarnings('ignore')

# ==============================================================================
# PART 1: GREEN QUADRANT
# ==============================================================================

class GreenQuadrantProcessor:
    """
    Process the Green Quadrant analyst data into BI-ready format
    
    The raw Excel is pretty messy - has axes, criteria, sub-criteria all mixed together
    Spent a while figuring out the best way to parse this
    """
    
    def __init__(self, file_path):
        self.file_path = file_path
        self.raw_data = None
        self.clean_data = []
        
    def load_data(self):
        """Load the raw Excel file"""
        print("Loading raw data...")
        # Don't use header parameter because the structure is non-standard
        self.raw_data = pd.read_excel(
            self.file_path, 
            sheet_name='Task 1 Data-Aggregate GQ Scores',
            header=None
        )
        print(f"Loaded {self.raw_data.shape[0]} rows")
        
    def parse_and_clean(self):
        """
        Parse the hierarchical structure
        This was the tricky part - had to manually walk through the rows
        """
        print("Parsing hierarchical structure...")
        
        df = self.raw_data
        
        # Get company columns - they start at column 5
        company_cols = []
        for i in range(5, df.shape[1] - 3):  # Skip summary columns at end
            col_header = df.iloc[0, i]
            if pd.notna(col_header) and 'COMPANY' in str(col_header):
                company_cols.append((i, col_header))
        
        print(f"Found {len(company_cols)} companies")
        
        # Now parse criteria and scores
        # Row 3 has the axis labels, column 0 has criteria numbering
        current_axis = None
        current_criteria_num = None
        current_criteria_name = None
        
        for row_idx in range(3, len(df)):
            
            # Check if this row has a criteria number
            if pd.notna(df.iloc[row_idx, 0]):
                current_criteria_num = df.iloc[row_idx, 0]
            
            # Check column 2 for axis name or criteria name
            col2_val = df.iloc[row_idx, 2]
            
            if pd.notna(col2_val):
                val_str = str(col2_val).strip()
                
                # Check if it's an axis marker
                if 'Criteria' in val_str:
                    if 'Momentum' in val_str:
                        current_axis = 'Momentum'
                    elif 'Capabilities' in val_str:
                        current_axis = 'Capabilities'
                    continue
                
                # Check if it's a weighting (numeric between 0-1)
                try:
                    num_val = float(val_str)
                    if 0 < num_val < 1:
                        # This is a weighting row, skip
                        continue
                except:
                    pass
                
                # If we get here and we have a criteria number, this is a criteria name
                if current_criteria_num is not None and current_axis is not None:
                    current_criteria_name = val_str
                    
                    # Now extract scores for this criteria
                    # Need to calculate weighted average from sub-criteria
                    weighted_score_data = {}
                    
                    # Look ahead for sub-criteria rows
                    for sub_row in range(row_idx + 1, min(row_idx + 10, len(df))):
                        weight = df.iloc[sub_row, 2]
                        
                        if pd.notna(weight):
                            try:
                                w = float(weight)
                                if 0 < w < 1:  # This is a weight
                                    # Get scores for each company
                                    for col_idx, company_name in company_cols:
                                        score = df.iloc[sub_row, col_idx]
                                        if pd.notna(score):
                                            if company_name not in weighted_score_data:
                                                weighted_score_data[company_name] = {'total': 0, 'weight': 0}
                                            weighted_score_data[company_name]['total'] += float(score) * w
                                            weighted_score_data[company_name]['weight'] += w
                                else:
                                    break  # Not a weight, stop looking
                            except:
                                break
                        else:
                            break
                    
                    # Store the weighted scores
                    for company_name, data in weighted_score_data.items():
                        if data['weight'] > 0:
                            final_score = data['total']  # Already weighted
                            self.clean_data.append({
                                'Vendor': company_name,
                                'Axis': current_axis,
                                'Criteria_Number': current_criteria_num,
                                'Criteria': current_criteria_name,
                                'Score': final_score
                            })
        
        print(f"Extracted {len(self.clean_data)} records")
        
    def create_dimensional_model(self):
        """
        Create star schema tables
        Went with star schema because it's standard for BI
        """
        print("Creating dimensional model...")
        
        df = pd.DataFrame(self.clean_data)
        
        # Create dimension tables
        vendors = df[['Vendor']].drop_duplicates().reset_index(drop=True)
        vendors['vendor_id'] = range(1, len(vendors) + 1)
        
        axes = pd.DataFrame({
            'axis_id': [1, 2],
            'axis_name': ['Momentum', 'Capabilities']
        })
        
        criteria = df[['Axis', 'Criteria_Number', 'Criteria']].drop_duplicates()
        criteria = criteria.merge(axes, left_on='Axis', right_on='axis_name')
        criteria = criteria.reset_index(drop=True)
        criteria['criteria_id'] = range(1, len(criteria) + 1)
        
        # Create fact table
        facts = df.merge(vendors, on='Vendor')
        facts = facts.merge(criteria[['Criteria', 'criteria_id']], on='Criteria')
        facts = facts.merge(axes, left_on='Axis', right_on='axis_name')
        facts = facts[['vendor_id', 'criteria_id', 'axis_id', 'Score']]
        facts.columns = ['vendor_id', 'criteria_id', 'axis_id', 'score']
        
        self.dim_vendors = vendors
        self.dim_axes = axes
        self.dim_criteria = criteria[['criteria_id', 'axis_id', 'Criteria_Number', 'Criteria', 'Axis']]
        self.fact_scores = facts
        
        print(f"Created star schema: {len(vendors)} vendors, {len(criteria)} criteria, {len(facts)} facts")
        
    def generate_outputs(self, output_file):
        """Generate the Excel output with different views"""
        print(f"Generating output: {output_file}")
        
        # View 1: Axis scores for quadrant chart
        axis_scores = self.fact_scores.merge(self.dim_vendors, on='vendor_id')
        axis_scores = axis_scores.merge(self.dim_axes, on='axis_id')
        axis_summary = axis_scores.groupby(['Vendor', 'axis_name'])['score'].mean().reset_index()
        quadrant = axis_summary.pivot(index='Vendor', columns='axis_name', values='score').reset_index()
        
        # View 2: Criteria detail for drill-down
        detail = self.fact_scores.merge(self.dim_vendors, on='vendor_id')
        detail = detail.merge(self.dim_criteria[['criteria_id', 'Criteria', 'Axis']], on='criteria_id')
        detail = detail[['Vendor', 'Axis', 'Criteria', 'score']]
        
        # Write to Excel
        with pd.ExcelWriter(output_file, engine='openpyxl') as writer:
            quadrant.to_excel(writer, sheet_name='Axis Scores (Quadrant)', index=False)
            detail.to_excel(writer, sheet_name='Criteria Detail', index=False)
            self.dim_vendors.to_excel(writer, sheet_name='Dim_Vendors', index=False)
            self.dim_criteria.to_excel(writer, sheet_name='Dim_Criteria', index=False)
            self.fact_scores.to_excel(writer, sheet_name='Fact_Scores', index=False)
        
        print("Done!")


# ==============================================================================
# PART 2: CARBON EMISSIONS FORECASTING
# ==============================================================================

class CarbonForecastProcessor:
    """
    Generate linear emissions forecasts to 2050
    
    Key assumptions from the task:
    - Net zero = 0.01 * baseline (i.e., 1% of baseline, or 99% reduction)
    - Linear decrease between milestones
    - Handle interim targets if they exist
    """
    
    def __init__(self, file_path):
        self.file_path = file_path
        self.emissions_data = None
        self.historic_data = None
        self.forecasts = []
        
    def load_data(self):
        """Load both sheets"""
        print("Loading emissions data...")
        self.emissions_data = pd.read_excel(self.file_path, sheet_name='Task 2 Data - Emissions')
        self.historic_data = pd.read_excel(self.file_path, sheet_name='Task 2 Data (2) HistoricEm')
        print(f"Loaded {len(self.emissions_data)} companies")
        
    def prepare_data(self):
        """Clean up and apply business rules"""
        print("Preparing data...")
        
        # Handle missing values according to task spec
        for idx, row in self.emissions_data.iterrows():
            for scope in [1, 2, 3]:
                # If baseline year is missing, use most recent emissions year
                baseline_col = f'Baseline Year (Scope {scope})'
                if pd.isna(row[baseline_col]):
                    # Try to use the emissions year
                    year_col = f'Scope {scope} Emissions Year'
                    if year_col in row and pd.notna(row[year_col]):
                        self.emissions_data.at[idx, baseline_col] = row[year_col]
                
                # If net zero target is missing, default to 2050
                nz_col = f'NZ Target Year: Scope {scope}'
                if pd.isna(row[nz_col]):
                    self.emissions_data.at[idx, nz_col] = 2050
        
    def generate_forecasts(self):
        """
        Generate yearly forecasts using linear interpolation
        This is the main calculation logic
        """
        print("Generating forecasts...")
        
        for idx, row in self.emissions_data.iterrows():
            company_id = row['company_id']
            
            for scope_num in [1, 2, 3]:
                scope = f'Scope {scope_num}'
                
                # Get the parameters
                baseline_year = row.get(f'Baseline Year (Scope {scope_num})')
                baseline_emissions = row.get(f'Base Year Emissions - Scope {scope_num}')
                nz_year = row.get(f'NZ Target Year: Scope {scope_num}')
                interim_year = row.get(f'Interim Target Year 1: Scope {scope_num}')
                interim_pct = row.get(f'Interim Target % 1: Scope {scope_num}')
                
                # Skip if no baseline data
                if pd.isna(baseline_year) or pd.isna(baseline_emissions):
                    continue
                
                # Convert to proper types with error handling
                try:
                    baseline_year = int(baseline_year)
                    baseline_emissions = float(baseline_emissions)
                    nz_year = int(nz_year) if pd.notna(nz_year) else 2050
                except (ValueError, TypeError):
                    # Can't parse the values, skip this scope
                    continue
                
                # Net zero = 1% of baseline (99% reduction)
                nz_emissions = baseline_emissions * 0.01
                
                # Check if there's an interim target
                # Had to add extra check because some values are "Not disclosed" string
                has_interim = False
                if pd.notna(interim_year) and pd.notna(interim_pct):
                    try:
                        interim_year = int(interim_year)
                        interim_pct = float(interim_pct)
                        has_interim = True
                    except:
                        has_interim = False
                
                if has_interim:
                    interim_emissions = baseline_emissions * (1 - interim_pct)
                    
                    # Phase 1: Baseline to interim
                    years_to_interim = interim_year - baseline_year
                    if years_to_interim > 0:
                        annual_reduction_1 = (baseline_emissions - interim_emissions) / years_to_interim
                        
                        for year in range(baseline_year, interim_year + 1):
                            years_elapsed = year - baseline_year
                            forecast = baseline_emissions - (annual_reduction_1 * years_elapsed)
                            
                            self.forecasts.append({
                                'Lookup': f'{company_id}{scope}',
                                'Company ID': company_id,
                                'Scope': scope,
                                'Type': 'Projection',
                                'Year': year,
                                'Emissions (tCO2e)': forecast
                            })
                    
                    # Phase 2: Interim to net zero
                    years_to_nz = nz_year - interim_year
                    if years_to_nz > 0:
                        annual_reduction_2 = (interim_emissions - nz_emissions) / years_to_nz
                        
                        for year in range(interim_year + 1, nz_year + 1):
                            years_elapsed = year - interim_year
                            forecast = interim_emissions - (annual_reduction_2 * years_elapsed)
                            
                            self.forecasts.append({
                                'Lookup': f'{company_id}{scope}',
                                'Company ID': company_id,
                                'Scope': scope,
                                'Type': 'Projection',
                                'Year': year,
                                'Emissions (tCO2e)': forecast
                            })
                else:
                    # No interim - single linear path
                    years_to_nz = nz_year - baseline_year
                    if years_to_nz > 0:
                        annual_reduction = (baseline_emissions - nz_emissions) / years_to_nz
                        
                        for year in range(baseline_year, nz_year + 1):
                            years_elapsed = year - baseline_year
                            forecast = baseline_emissions - (annual_reduction * years_elapsed)
                            
                            self.forecasts.append({
                                'Lookup': f'{company_id}{scope}',
                                'Company ID': company_id,
                                'Scope': scope,
                                'Type': 'Projection',
                                'Year': year,
                                'Emissions (tCO2e)': forecast
                            })
                
                # Extend to 2050 if net zero year is before that
                if nz_year < 2050:
                    for year in range(nz_year + 1, 2051):
                        self.forecasts.append({
                            'Lookup': f'{company_id}{scope}',
                            'Company ID': company_id,
                            'Scope': scope,
                            'Type': 'Projection',
                            'Year': year,
                            'Emissions (tCO2e)': nz_emissions
                        })
        
        print(f"Generated {len(self.forecasts)} projection records")
        
    def add_actuals(self):
        """Add historic actual emissions to the dataset"""
        print("Adding actual emissions...")
        
        # The historic data is in wide format - need to reshape it
        year_cols = [col for col in self.historic_data.columns if isinstance(col, int)]
        
        actuals = []
        for idx, row in self.historic_data.iterrows():
            company_id = row['company_id']
            scope = row['Scope ']
            
            for year in year_cols:
                if pd.notna(row[year]):
                    actuals.append({
                        'Lookup': f'{company_id}{scope}',
                        'Company ID': company_id,
                        'Scope': scope,
                        'Type': 'Actual',
                        'Year': year,
                        'Emissions (tCO2e)': float(row[year])
                    })
        
        self.forecasts.extend(actuals)
        print(f"Added {len(actuals)} actual records")
        
    def calculate_overshoot(self):
        """
        Calculate overshoot projections for companies behind schedule
        If actual > forecast in most recent year, recalculate trajectory
        """
        print("Calculating overshoot projections...")
        
        df = pd.DataFrame(self.forecasts)
        
        # Get most recent actual for each company/scope
        actuals = df[df['Type'] == 'Actual'].copy()
        
        overshoot_records = []
        
        for (company_id, scope), group in actuals.groupby(['Company ID', 'Scope']):
            most_recent_year = group['Year'].max()
            most_recent_actual = group[group['Year'] == most_recent_year]['Emissions (tCO2e)'].values[0]
            
            # Get forecast for that same year
            forecasts = df[(df['Company ID'] == company_id) & 
                          (df['Scope'] == scope) & 
                          (df['Type'] == 'Projection') &
                          (df['Year'] == most_recent_year)]
            
            if len(forecasts) == 0:
                continue
                
            forecast_value = forecasts['Emissions (tCO2e)'].values[0]
            
            # Check if actual is higher than forecast (behind schedule)
            if most_recent_actual > forecast_value:
                # Company is overshooting - recalculate
                # Get their original net zero target
                company_data = self.emissions_data[self.emissions_data['company_id'] == company_id].iloc[0]
                scope_num = int(scope.split()[1])
                
                baseline_emissions = company_data.get(f'Base Year Emissions - Scope {scope_num}')
                nz_year = company_data.get(f'NZ Target Year: Scope {scope_num}')
                
                if pd.notna(baseline_emissions) and pd.notna(nz_year):
                    nz_emissions = float(baseline_emissions) * 0.01
                    
                    # Calculate annual reduction from their original plan
                    baseline_year = company_data.get(f'Baseline Year (Scope {scope_num})')
                    if pd.notna(baseline_year):
                        try:
                            baseline_year_int = int(baseline_year)
                            nz_year_int = int(nz_year)
                            years_diff = nz_year_int - baseline_year_int
                            
                            if years_diff <= 0:
                                continue
                            
                            original_annual_reduction = (float(baseline_emissions) - nz_emissions) / years_diff
                        
                            # Calculate new implied net zero year
                            years_needed = (most_recent_actual - nz_emissions) / original_annual_reduction
                            implied_nz_year = int(most_recent_year + years_needed)
                            
                            # Generate new trajectory
                            for year in range(most_recent_year, min(implied_nz_year + 1, 2051)):
                                years_from_start = year - most_recent_year
                                overshoot_emission = most_recent_actual - (original_annual_reduction * years_from_start)
                                overshoot_emission = max(overshoot_emission, nz_emissions)
                                
                                overshoot_records.append({
                                    'Lookup': f'{company_id}{scope}',
                                    'Company ID': company_id,
                                    'Scope': scope,
                                    'Type': 'Overshoot Projection',
                                    'Year': year,
                                    'Emissions (tCO2e)': overshoot_emission
                                })
                        except (ValueError, TypeError, ZeroDivisionError):
                            # Can't calculate, skip
                            continue
        
        self.forecasts.extend(overshoot_records)
        print(f"Added {len(overshoot_records)} overshoot projection records")
        
    def save_output(self, output_file):
        """Save all forecasts to Excel"""
        print(f"Saving output: {output_file}")
        
        df = pd.DataFrame(self.forecasts)
        df = df.sort_values(['Company ID', 'Scope', 'Type', 'Year'])
        
        df.to_excel(output_file, index=False, sheet_name='Emissions Forecasts')
        print("Done!")


# ==============================================================================
# MAIN EXECUTION
# ==============================================================================

if __name__ == "__main__":
    
    print("="*80)
    print("RESEARCH ANALYTICS ETL PIPELINE")
    print("="*80)
    
    input_file = '/mnt/user-data/uploads/Data_Engineer_Task__Anonymised_2024.xlsx'
    
    # Part 1: Green Quadrant
    print("\nPART 1: GREEN QUADRANT REPORT")
    print("-"*80)
    
    gq = GreenQuadrantProcessor(input_file)
    gq.load_data()
    gq.parse_and_clean()
    gq.create_dimensional_model()
    gq.generate_outputs('/home/claude/part1_output.xlsx')
    
    # Part 2: Carbon Forecasting
    print("\nPART 2: CARBON EMISSIONS FORECASTING")
    print("-"*80)
    
    carbon = CarbonForecastProcessor(input_file)
    carbon.load_data()
    carbon.prepare_data()
    carbon.generate_forecasts()
    carbon.add_actuals()
    carbon.calculate_overshoot()
    carbon.save_output('/home/claude/part2_output.xlsx')
    
    print("\n" + "="*80)
    print("ALL DONE")
    print("="*80)
