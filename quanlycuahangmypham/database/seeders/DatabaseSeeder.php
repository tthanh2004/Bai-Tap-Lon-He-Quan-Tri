<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KhachhangSeeder::class,
            NhanvienSeeder::class,
            TheTichDiemSeeder::class,
            HangSeeder::class,
            SanPhamSeeder::class,
            NhapHangSeeder::class,
            HoaDonSeeder::class,
            ChiTietHoaDonSeeder::class,
        ]);

        Permission::create(['name' => 'view dashboard']);
        Permission::create(['name' => 'manage products']);
        Permission::create(['name' => 'view invoices']);
        Permission::create(['name' => 'checkout']);
        Permission::create(['name' => 'admin panel']);
        $admin = Role::create(['name' => 'admin']);
        $customer = Role::create(['name' => 'customer']);
        $staff = Role::create(['name' => 'staff']);

        $admin->givePermissionTo(['view dashboard']);
        $customer->givePermissionTo(['view dashboard', 'view invoices', 'checkout']);
        $staff->givePermissionTo(['view dashboard', 'manage products']);

        $user = User::find(1);
        $user->assignRole($admin);
    }
}
