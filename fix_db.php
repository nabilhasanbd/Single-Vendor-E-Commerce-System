<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

Schema::table('products', function (Blueprint $table) {
    if (Schema::hasColumn('products', 'stock_quantity') && !Schema::hasColumn('products', 'stock')) {
        $table->renameColumn('stock_quantity', 'stock');
    }
    if (!Schema::hasColumn('products', 'image_url')) {
        $table->string('image_url')->nullable()->after('stock');
    }
    if (Schema::hasColumn('products', 'status') && !Schema::hasColumn('products', 'is_active')) {
        $table->renameColumn('status', 'is_active');
    }
});
echo "Table structure patched!";
