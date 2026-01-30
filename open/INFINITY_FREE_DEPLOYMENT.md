# Infinity Free Deployment Guide

## 📋 Pre-Deployment Checklist

- ✅ Database exported: `database_production_backup.sql` (0.23 MB)
- ✅ All config files optimized for production
- ✅ Database.php has deployment comments
- ✅ .htaccess properly configured
- ✅ All test/debug files removed
- ✅ Logging disabled (log_threshold = 0)
- ✅ Database errors hidden (db_debug = FALSE)

---

## 🚀 Step-by-Step Deployment

### STEP 1: Create Infinity Free Account
1. Go to **https://infinityfree.net**
2. Sign up with your email
3. Create a new website/domain
4. Remember your username (used for database credentials)

### STEP 2: Create & Import Database

**Option A: Using phpMyAdmin (Recommended)**

1. Log in to Infinity Free dashboard
2. Navigate to **MySQL Databases**
3. Click **Create Database**
   - Database will be created as: `if0_<username>_db`
   - Username will be: `if0_<username>`
   - Set a strong password and save it
4. Click **phpMyAdmin** to open database manager
5. Select your newly created database
6. Click **Import** tab
7. Upload the file: `database_production_backup.sql`
8. Click **Go** to import (wait for completion)

**Option B: Using Command Line (if available)**
```bash
mysql -h localhost -u if0_username -p if0_username_db < database_production_backup.sql
```

### STEP 3: Update Configuration File

**Before uploading, edit this file:**

📄 `application/config/database.php`

Replace these lines (around line 68-73):
```php
'hostname' => 'localhost',
'username' => 'root',                    // CHANGE THIS
'password' => '',                        // CHANGE THIS
'database' => 'open',                    // CHANGE THIS
```

With your actual Infinity Free credentials:
```php
'hostname' => 'localhost',
'username' => 'if0_YOUR_EXACT_USERNAME',      // From Infinity Free
'password' => 'YOUR_DB_PASSWORD',              // You set this
'database' => 'if0_YOUR_EXACT_USERNAME_db',   // From Infinity Free
```

**Example:**
```php
'hostname' => 'localhost',
'username' => 'if0_john1234',
'password' => 'MySecurePass123!',
'database' => 'if0_john1234_db',
```

### STEP 4: Upload Files via FTP

**Using Infinity Free File Manager (Easiest):**

1. In Infinity Free dashboard, click **Files**
2. Navigate to **public_html** folder
3. Delete any existing files
4. Upload all files from your local folder `/open`:
   - `index.php`
   - `.htaccess`
   - `application/` (entire folder)
   - `system/` (entire folder)
   - `assets/` (entire folder)
   - `js/` (entire folder)
   - `uploads/` (create if missing)
   - `tmp/` (create if missing)
   - `data/`
   - `dist/`
   - `optimum/`

**Using FTP Client (FileZilla recommended):**

1. Get FTP credentials from Infinity Free dashboard
2. Connect to: `ftp.your-domain.infinityfree.net`
3. Username: Your Infinity Free username
4. Password: Your Infinity Free password
5. Navigate to `public_html`
6. Upload all files maintaining folder structure

### STEP 5: Set File Permissions

**Via Infinity Free File Manager:**

1. Right-click each folder
2. Click **Change Permissions**
3. Set these permissions:

| Folder | Permission | Code |
|--------|-----------|------|
| `/uploads` | Read + Write + Execute | 777 |
| `/tmp` | Read + Write + Execute | 777 |
| `/` (root) | Read + Execute | 755 |
| `.htaccess` | Read | 644 |

**Via FTP Client (FileZilla):**
- Right-click folder → File Attributes
- Set numeric value: 777 for uploads/tmp, 755 for others

### STEP 6: Verify Installation

1. Visit your Infinity Free domain (e.g., `yoursite.infinityfree.app`)
2. Should see **School Management System** login page
3. Log in with your admin credentials from the database
   - If unsure, reset password in phpmyadmin:
   ```sql
   UPDATE admin SET password = SHA1('newpassword123') WHERE admin_id = 1;
   ```
4. Test basic functions:
   - View dashboard
   - Check student list
   - View reports

### STEP 7: Enable SSL/HTTPS

1. Go to Infinity Free dashboard → **SSL**
2. Click **Install Free SSL**
3. Wait for certificate to be issued (~10 minutes)
4. Update bookmarks to use `https://` instead of `http://`

---

## 🔐 Post-Deployment Security

### Change Default Passwords
```sql
-- Change admin password
UPDATE admin SET password = SHA1('YourNewSecurePassword') WHERE admin_id = 1;

-- Change other users
UPDATE teacher SET password = SHA1('TeacherPassword') WHERE teacher_id = 1;
UPDATE student SET password = SHA1('StudentPassword') WHERE student_id = 1;
```

### Remove Sensitive Files
Do NOT upload these files:
- `database_production_backup.sql` (keep it safe locally!)
- Any backup files
- Configuration examples

### Monitor Security
1. Regularly check Infinity Free logs
2. Set up automated backups (Infinity Free provides this)
3. Keep passwords secure and unique
4. Change admin password monthly

---

## ⚠️ Troubleshooting

### Problem: "Database connection failed"
**Solution:**
1. Verify credentials in `database.php` match exactly (case-sensitive)
2. Ensure database was created in Infinity Free
3. Check if database contains tables (verify import successful)
4. Try connecting via phpMyAdmin first

### Problem: "404 Error" or blank pages
**Solution:**
1. Verify `.htaccess` was uploaded to root
2. Check Infinity Free mod_rewrite is enabled (usually is)
3. Set `$config['index_page'] = '';` in `config.php`
4. Verify all files uploaded completely

### Problem: "Permission denied" errors
**Solution:**
1. Set `uploads/` and `tmp/` permissions to 777
2. Verify file ownership
3. Try 755 instead of 777 if 777 doesn't work

### Problem: "Session errors" or "Cookie not working"
**Solution:**
1. Set this in `config.php`:
   ```php
   $config['sess_driver'] = 'files';
   $config['sess_save_path'] = APPPATH . 'cache/';
   ```
2. Ensure `application/cache/` directory exists and is writable
3. Create the directory if needed via FTP

### Problem: "Maximum execution time exceeded"
**Solution:**
1. Some operations may timeout on free tier
2. Generate reports in smaller batches
3. Use pagination for large lists

---

## 📞 Support Resources

- **Infinity Free Docs:** https://infinityfree.net/
- **CodeIgniter Docs:** https://codeigniter.com/
- **MySQL Help:** Use phpMyAdmin built-in help
- **FTP Issues:** Try FileZilla support

---

## 📝 Important Notes

✅ **Keep Backups:**
- Download `database_production_backup.sql` and store safely
- Use Infinity Free's backup feature
- Download backups weekly

✅ **Monitor Usage:**
- Infinity Free provides 5 GB storage
- 100 GB bandwidth/month
- Check usage regularly

✅ **Database Credentials:**
- NEVER share your password
- NEVER commit credentials to public repos
- Update password if exposed

---

## ✨ Quick Reference

| Item | Value |
|------|-------|
| Base URL | `yoursite.infinityfree.app` |
| FTP Host | `ftp.yoursite.infinityfree.app` |
| MySQL Host | `localhost` |
| phpMyAdmin | In dashboard under MySQL Databases |
| Root Directory | `public_html/` |
| Database Size | ~0.5-1 MB |
| Supported PHP | 7.0+ |

---

## 🎉 You're Ready!

Your school management system is now live on Infinity Free!

**Next Steps:**
1. Add your school data
2. Create teacher accounts
3. Register students
4. Start using the system!

**Questions?** Check the support resources above or contact Infinity Free support.

---

*Last Updated: January 27, 2026*
*Document Version: 1.0 (Production Ready)*
