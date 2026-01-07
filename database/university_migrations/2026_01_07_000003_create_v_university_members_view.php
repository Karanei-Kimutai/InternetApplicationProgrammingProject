<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::connection('university')->statement('
            CREATE VIEW v_university_members AS
            SELECT id, name, email, password, photo_url, "student" AS role FROM students
            UNION ALL
            SELECT id, name, email, password, photo_url, "lecturer" AS role FROM lecturers
        ');
    }

    public function down(): void
    {
        DB::connection('university')->statement("DROP VIEW IF EXISTS v_university_members");
    }
};
