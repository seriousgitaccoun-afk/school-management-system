# Academic Calendar JSON Schema & Import

This folder contains a JSON schema and example files for academic years and terms. Use it to seed your database or create calendar entries.

Files:
- `academic_calendar_schema.json` — JSON Schema you can validate against.
- `academic_calendar_2025_2026.json` — Example for 2025/2026 based on Ghana's basic school calendar.

Import helper:
- `../tools/import_academic_calendar.php` — CLI script to import JSON into the database. It reads DB credentials from `application/config/database.php` (CI standard config) and inserts/updates academic_years and academic_terms.

Usage Example:

1. Open a terminal in the project folder and run (PowerShell):

```powershell
php .\open\tools\import_academic_calendar.php .\open\data\academic_calendar_2025_2026.json
```

2. Verify the database entries:

```sql
SELECT * FROM academic_years WHERE year_name = '2025/2026';
SELECT * FROM academic_terms WHERE academic_year_id = <id> ORDER BY academic_term_id;
```

Notes:
- Dates in the sample are approximate and model the typical Ghana 2025/2026 basic school calendar.
- The seed can be adjusted to specific school dates; the import script will update existing rows using ON DUPLICATE KEY style updates for idempotency.
- The script does not yet store milestones/midterm breaks in a separate table; this can be added in the future.

Potential next steps:
- Add a small table for `term_milestones` to store major events like BECE for JHS3.
- Add an admin UI to import or edit JSON and preview the seed.
- Add the data import to a migration/seeder process for CI build steps.

