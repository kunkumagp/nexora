<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        // Create trigger depending on driver. MySQL and SQLite require different syntax.
        try {
            $driver = DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME);
        } catch (\Throwable $e) {
            // Fallback if PDO not available for some reason
            $driver = null;
        }

        if ($driver === 'mysql') {
            // MySQL trigger
            DB::unprepared('\n            CREATE TRIGGER prevent_negative_stock BEFORE INSERT ON stock_movements\n            FOR EACH ROW\n            BEGIN\n                IF NEW.type = "out" THEN\n                    DECLARE current_stock INT;\n                    SELECT COALESCE(SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END), 0)\n                      INTO current_stock\n                      FROM stock_movements\n                      WHERE product_id = NEW.product_id AND warehouse_id = NEW.warehouse_id AND deleted_at IS NULL;\n                    IF current_stock < NEW.quantity THEN\n                        SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Insufficient stock";\n                    END IF;\n                END IF;\n            END;\n            ');
        } elseif ($driver === 'sqlite') {
            // SQLite trigger: use WHEN clause and RAISE(ABORT, 'message') to abort the insert
            DB::unprepared('\n            CREATE TRIGGER prevent_negative_stock BEFORE INSERT ON stock_movements\n            FOR EACH ROW\n            WHEN (NEW.type = "out" AND (\n                (SELECT COALESCE(SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END), 0)\n                    FROM stock_movements\n                    WHERE product_id = NEW.product_id AND warehouse_id = NEW.warehouse_id AND deleted_at IS NULL) < NEW.quantity\n            ))\n            BEGIN\n                SELECT RAISE(ABORT, "Insufficient stock");\n            END;\n            ');
        } else {
            // Unknown driver - skip trigger creation.
        }
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS prevent_negative_stock;');
    }
};
<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        // Create trigger depending on driver. MySQL and SQLite require different syntax.
        try {
            $driver = DB::connection()->getPDO()->getAttribute(PDO::ATTR_DRIVER_NAME);
        } catch (\Throwable $e) {
            // Fallback if PDO not available for some reason
            $driver = DB::getDriverName() ?? null;
        }

        if ($driver === 'mysql') {
            // MySQL trigger (original)
            DB::unprepared('
            CREATE TRIGGER prevent_negative_stock BEFORE INSERT ON stock_movements
            <?php
            use Illuminate\Support\Facades\DB;
            use Illuminate\Database\Migrations\Migration;

            return new class extends Migration {
                public function up(): void
                {
                    // Create trigger depending on driver. MySQL and SQLite require different syntax.
                    try {
                        $driver = DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME);
                    } catch (\Throwable $e) {
                        // Fallback if PDO not available for some reason
                        $driver = null;
                    }

                    if ($driver === 'mysql') {
                        // MySQL trigger (original)
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
                    } elseif ($driver === 'sqlite') {
                        // SQLite trigger: use WHEN clause and RAISE(ABORT, 'message') to abort the insert
                        DB::unprepared('
                        CREATE TRIGGER prevent_negative_stock BEFORE INSERT ON stock_movements
                        FOR EACH ROW
                        WHEN (NEW.type = "out" AND (
                            (SELECT COALESCE(SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END), 0)
                                FROM stock_movements
                                WHERE product_id = NEW.product_id AND warehouse_id = NEW.warehouse_id AND deleted_at IS NULL) < NEW.quantity
                        ))
                        BEGIN
                            SELECT RAISE(ABORT, "Insufficient stock");
                        END;
                        ');
                    } else {
                        // Unknown driver - skip trigger creation.
                    }
                }

                public function down(): void
                {
                    // Try to drop the trigger; some drivers may ignore IF EXISTS
                    DB::unprepared('DROP TRIGGER IF EXISTS prevent_negative_stock;');
                }
            };
};
