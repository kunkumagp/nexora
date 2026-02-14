<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        // Prevent negative stock (MySQL trigger example)
        DB::unprepared('
        CREATE TRIGGER prevent_negative_stock BEFORE INSERT ON stock_movements
        FOR EACH ROW
        BEGIN
            IF NEW.type = "out" THEN
                DECLARE current_stock INT;
                SELECT COALESCE(SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END), 0)
                  INTO current_stock
                  FROM stock_movements
                  WHERE product_id = NEW.product_id AND warehouse_id = NEW.warehouse_id AND deleted_at IS NULL;
                IF current_stock < NEW.quantity THEN
                    SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Insufficient stock";
                END IF;
            END IF;
        END;
        ');
    }
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS prevent_negative_stock;');
    }
};
