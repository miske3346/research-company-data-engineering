# Complete Setup Guide - Research Analytics ETL Pipeline

Follow these steps to get your project on GitHub. Takes about 20 minutes.

---

## STEP 1: Extract Files

1. Locate `research-company-data-engineering.tar.gz`
2. Extract to `C:\Users\Administrator\Downloads\`
3. Verify folder structure:
   - src/ (Python and SQL code)
   - outputs/ (Excel results)
   - docs/ (documentation)
   - README.md
   - LICENSE

---

## STEP 2: Open PowerShell in Project Folder

**Easy Method:**
1. Open File Explorer
2. Navigate to `research-company-data-engineering` folder
3. Click in address bar (top)
4. Type: `powershell`
5. Press Enter

**Verify you're in right place:**
```powershell
ls
# Should show: src, outputs, docs, README.md
```

---

## STEP 3: Install Python Dependencies

```powershell
python -m pip install pandas numpy openpyxl
```

Should see: `Successfully installed pandas... numpy... openpyxl...`

---

## STEP 4: Create GitHub Repository

1. Go to: https://github.com/new
2. Fill in:
   - **Name:** `research-company-data-engineering`
   - **Description:** `End-to-end ETL pipeline for research analytics data processing and emissions forecasting`
   - **Public** repository
   - **Don't check any boxes** (we have README/LICENSE already)
3. Click "Create repository"
4. Leave page open

---

## STEP 5: Configure Git (One-Time)

Replace email with yours:

```powershell
git config --global user.email "aymanahassan2@gmail.com"
git config --global user.name "aymanfoundry"
```

---

## STEP 6: Push to GitHub

Run these commands in order:

```powershell
git init
git add .
git commit -m "Initial commit: Research analytics ETL pipeline"
git branch -M main
git remote add origin https://github.com/aymanfoundry/research-company-data-engineering.git
git push -u origin main
```

Browser will open for authentication - sign in and authorize.

---

## STEP 7: Configure Repository

Visit: https://github.com/aymanfoundry/research-company-data-engineering

### Add Topics:
Click gear icon ⚙️ next to "About", add:
- `data-engineering`
- `etl`
- `python`
- `postgresql`
- `dimensional-modeling`
- `api-integration`
- `research-analytics`
- `portfolio-project`

### Verify Description:
Should show: "End-to-end ETL pipeline for research analytics data processing and emissions forecasting"

---

## STEP 8: Pin to Profile

1. Go to: https://github.com/aymanfoundry
2. Click "Customize your pins"
3. Select `research-company-data-engineering`
4. Save

---

## STEP 9: Share It

### LinkedIn Post:

```
Built an end-to-end ETL pipeline for processing research analytics data from API sources.

Key features:
• Dimensional modeling (star schema) for vendor analytics
• Time-series forecasting for emissions projections
• Dual Python/PostgreSQL implementation
• 1,300+ fact records processed

Tech: Python, PostgreSQL, pandas, dimensional modeling

https://github.com/aymanfoundry/research-company-data-engineering

#DataEngineering #Python #ETL #PostgreSQL
```

### Resume:

```
Research Analytics ETL Pipeline | Python, PostgreSQL, pandas
• Engineered ETL pipeline processing vendor analytics from research API sources
• Designed star schema dimensional model with 1,300+ fact records
• Built dual Python/PostgreSQL implementation demonstrating production architecture
• Implemented linear forecasting algorithm for emissions projections to 2050
• GitHub: github.com/aymanfoundry/research-company-data-engineering
```

---

## Troubleshooting

**"python not found"**
→ Install from https://www.python.org/downloads/
→ Restart PowerShell

**"git not found"**
→ Install from https://git-scm.com/download/win
→ Restart PowerShell

**"remote origin already exists"**
```powershell
git remote remove origin
git remote add origin https://github.com/aymanfoundry/research-company-data-engineering.git
```

---

## Checklist - You're Done When:

- [ ] Repo exists: github.com/aymanfoundry/research-company-data-engineering
- [ ] README shows "Ayman Hassan" at bottom
- [ ] 8 topics added to repository
- [ ] Repository is PUBLIC
- [ ] Pinned to your profile
- [ ] All files visible on GitHub
- [ ] Posted on LinkedIn
- [ ] Added to resume

---

**Time:** 20 minutes  
**Result:** Professional portfolio project ready for recruiters!
