# Quick Fix for PowerShell Issues

## Problem 1: pip not recognized

**Error:** `pip : The term 'pip' is not recognized...`

**Solution - Use python -m pip:**
```powershell
python -m pip install -r requirements.txt
```

If that doesn't work, try:
```powershell
python3 -m pip install -r requirements.txt
```

Or use the full path:
```powershell
py -m pip install -r requirements.txt
```

---

## Problem 2: File not found error

**Error:** `Could not open requirements file: [Errno 2] No such file or directory: 'requirements.txt'`

**This means you're not in the right folder.**

**Solution:**

### Step 1: Find where you extracted the files
```powershell
# List what's in current folder
ls
```

You should see:
- src/
- outputs/
- docs/
- README.md
- requirements.txt
- etc.

If you DON'T see these, you're in the wrong folder.

### Step 2: Navigate to the correct folder

The folder should be called `research-company-data-engineering`

**Find it:**
```powershell
# If it's in Downloads
cd C:\Users\Administrator\Downloads\research-company-data-engineering

# Or wherever you extracted it
cd "path\to\research-company-data-engineering"
```

### Step 3: Verify you're in the right place
```powershell
ls

# You should see:
# - src
# - outputs
# - docs
# - README.md
# - requirements.txt
```

### Step 4: Now install dependencies
```powershell
python -m pip install -r requirements.txt
```

---

## Full Clean Start

If you're still having issues, start fresh:

### 1. Extract the tar.gz file
- Right-click `research-company-data-engineering-final.tar.gz`
- Click "Extract All" (or use 7-Zip)
- Remember where it extracts to (e.g., Downloads folder)

### 2. Open PowerShell in that folder
**Option A - Easy way:**
- Open File Explorer
- Navigate to the `research-company-data-engineering` folder
- In the address bar, type `powershell` and press Enter
- PowerShell will open in that folder

**Option B - Command way:**
```powershell
cd C:\Users\Administrator\Downloads\research-company-data-engineering
```

### 3. Verify you're in the right place
```powershell
ls
# Should show: src, outputs, docs, README.md, requirements.txt, etc.
```

### 4. Install dependencies
```powershell
python -m pip install -r requirements.txt
```

---

## Expected Output

When it works, you'll see:
```
Collecting pandas>=2.0.0
  Downloading pandas-2.x.x-...
Collecting numpy>=1.24.0
  Downloading numpy-1.x.x-...
Collecting openpyxl>=3.1.0
  Downloading openpyxl-3.x.x-...
...
Successfully installed numpy-1.x.x pandas-2.x.x openpyxl-3.x.x
```

---

## Quick Checklist

- [ ] Extracted the tar.gz file
- [ ] Opened PowerShell in the `research-company-data-engineering` folder
- [ ] Can see README.md, requirements.txt when running `ls`
- [ ] Used `python -m pip install -r requirements.txt`
- [ ] Dependencies installed successfully

---

## Still Not Working?

**Check Python is installed:**
```powershell
python --version
# Should show: Python 3.9.x or higher
```

If it says "python not found":
1. Download Python from https://www.python.org/downloads/
2. **IMPORTANT:** Check "Add Python to PATH" during installation
3. Restart PowerShell
4. Try again

---

## After Dependencies Install

You can then:

**Test the script:**
```powershell
python src\solution_realistic.py
```

**Set up Git:**
```powershell
git init
git add .
git commit -m "Initial commit"
```

**Push to GitHub:**
```powershell
git remote add origin https://github.com/YOUR_USERNAME/research-company-data-engineering.git
git branch -M main
git push -u origin main
```
