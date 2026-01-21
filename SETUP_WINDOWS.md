# Windows Setup Guide

## For PowerShell Users

### 1. Extract and Navigate

Extract the archive and open PowerShell in the folder:
- Open File Explorer
- Navigate to `research-company-data-engineering` folder
- Type `powershell` in the address bar and press Enter

Or manually:
```powershell
cd C:\Users\YourName\Downloads\research-company-data-engineering
```

### 2. Verify Location

```powershell
ls
# Should see: src/, outputs/, docs/, README.md, requirements.txt
```

### 3. Install Dependencies

```powershell
python -m pip install -r requirements.txt
```

**Not `pip install` - use `python -m pip install`**

### 4. Test Script

```powershell
python src\solution_realistic.py
```

### 5. Push to GitHub

```powershell
git init
git add .
git commit -m "Initial commit: Research analytics portfolio project"
git remote add origin https://github.com/YOUR_USERNAME/research-company-data-engineering.git
git branch -M main
git push -u origin main
```

## Troubleshooting

**pip not recognized:**
Use `python -m pip` instead of `pip`

**File not found:**
Make sure you're in the `research-company-data-engineering` folder

**Python not found:**
Download from https://www.python.org/downloads/
Check "Add Python to PATH" during installation
