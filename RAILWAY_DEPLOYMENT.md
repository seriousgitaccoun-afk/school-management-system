# GitHub & Railway Deployment Guide

## Step 1: Initialize Git & Push to GitHub

### 1.1 Create a GitHub Repository
1. Go to [github.com](https://github.com)
2. Click **New Repository**
3. Name it (e.g., `school-management-system`)
4. Don't add README/License yet (we'll push existing code)
5. Click **Create Repository**

### 1.2 Push Your Code
Open Command Prompt in your project folder:

```
cd C:\xampp\htdocs\free_and_open_source
git init
git add .
git commit -m "Initial commit: School management system"
git branch -M main
git remote add origin https://github.com/YOUR-USERNAME/school-management-system.git
git push -u origin main
```

Replace `YOUR-USERNAME` with your GitHub username.

---

## Step 2: Set Up Railway Deployment

### 2.1 Create Railway Account
1. Go to [railway.app](https://railway.app)
2. Sign up with GitHub (easiest)
3. Authorize Railway to access your GitHub

### 2.2 Create New Project
1. Click **New Project**
2. Select **GitHub Repo**
3. Choose your repository
4. Railway will auto-detect it's a PHP project

### 2.3 Add MySQL Database
1. Click **Add Service**
2. Select **MySQL**
3. Railway creates database automatically
4. Copy the connection details

### 2.4 Set Environment Variables
In Railway Dashboard → Variables:

```
DB_HOST=mysql.railway.internal
DB_USER=root
DB_PASS=YOUR_MYSQL_PASSWORD
DB_NAME=open
ENVIRONMENT=production
```

Get these values from Railway's MySQL service details.

### 2.5 Deploy
1. Click **Deploy**
2. Wait 2-3 minutes
3. Railway generates a public URL
4. Your app is live!

---

## Step 3: Import Your Database

After deployment:
1. Go to Railway → MySQL → Connect
2. Use phpMyAdmin or command line
3. Import your database SQL file (from `/open/database_clean_structure.sql`)
4. Your app is ready!

---

## Troubleshooting

**Database won't connect?**
- Check environment variables match MySQL credentials
- Import your SQL schema

**Blank page?**
- Check Railway logs in dashboard
- Ensure mod_rewrite is enabled

**File upload issues?**
- Railway: uploads folder needs read/write permissions
- May need to use cloud storage (AWS S3) for production

---

## To Update Code in Future
Just push to GitHub:
```
git add .
git commit -m "Your changes"
git push origin main
```

Railway auto-deploys within seconds!

---

**Need help?** Check Railway docs: https://docs.railway.app
