<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyNotificationsTable extends Migration
{
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Drop the existing 'type' column if it exists (optional)
            if (Schema::hasColumn('notifications', 'type')) {
                $table->dropColumn('type');
            }

            // Add 'type' column
            $table->string('type')->nullable()->after('id');

            // Drop the existing 'notifiable_id' and 'notifiable_type' columns if they exist (optional)
            if (Schema::hasColumn('notifications', 'notifiable_id')) {
                $table->dropColumn('notifiable_id');
            }
            if (Schema::hasColumn('notifications', 'notifiable_type')) {
                $table->dropColumn('notifiable_type');
            }

            // Add 'notifiable_id' and 'notifiable_type' columns for polymorphic relations
            $table->unsignedBigInteger('notifiable_id')->after('type');
            $table->string('notifiable_type')->after('notifiable_id');

            // Drop the existing 'data' column if it exists (optional)
            if (Schema::hasColumn('notifications', 'data')) {
                $table->dropColumn('data');
            }

            // Add 'data' column as longText
            $table->longText('data')->after('notifiable_type');

            // Add indexes if needed
            $table->index(['notifiable_id', 'notifiable_type']);
        });
    }

    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Reverse the changes made in 'up' method if necessary
            $table->dropColumn('type');
            $table->dropColumn('notifiable_id');
            $table->dropColumn('notifiable_type');
            $table->dropColumn('data');
        });
    }
}
