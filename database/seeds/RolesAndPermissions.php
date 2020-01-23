<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // create permissions
        //USUARIO
        Permission::create(['name' => 'create-user']);
        Permission::create(['name' => 'read-users']);
        Permission::create(['name' => 'update-user']);
        Permission::create(['name' => 'delete-user']);

        //ROLES
        Permission::create(['name' => 'create-role']);
        Permission::create(['name' => 'read-roles']);
        Permission::create(['name' => 'update-role']);
        Permission::create(['name' => 'delete-role']);

        //VENDEDORES
        Permission::create(['name' => 'create-vendedor']);
        Permission::create(['name' => 'read-vendedors']);
        Permission::create(['name' => 'update-vendedor']);
        Permission::create(['name' => 'delete-vendedor']);

        //CLIENTE
        Permission::create(['name' => 'create-cliente']);
        Permission::create(['name' => 'read-clientes']);
        Permission::create(['name' => 'update-cliente']);
        Permission::create(['name' => 'delete-cliente']);

        //PAGO
        Permission::create(['name' => 'create-pago']);
        Permission::create(['name' => 'read-pagos']);
        Permission::create(['name' => 'update-pago']);
        Permission::create(['name' => 'delete-pago']);

        //ARTICULO
        Permission::create(['name' => 'create-articulo']);
        Permission::create(['name' => 'read-articulos']);
        Permission::create(['name' => 'update-articulo']);
        Permission::create(['name' => 'delete-articulo']);

        //CATEGORIA
        Permission::create(['name' => 'create-categoria']);
        Permission::create(['name' => 'read-categorias']);
        Permission::create(['name' => 'update-categoria']);
        Permission::create(['name' => 'delete-categoria']);

        //FACTURA
        Permission::create(['name' => 'create-factura']);
        Permission::create(['name' => 'read-facturas']);
        Permission::create(['name' => 'update-factura']);
        Permission::create(['name' => 'delete-factura']);

        //REGISTRO PAGOS
        Permission::create(['name' => 'create-registropago']);
        Permission::create(['name' => 'read-registropagos']);
        Permission::create(['name' => 'update-registropago']);
        Permission::create(['name' => 'delete-registropago']);

        //CLASIFICACIO PAGO
        Permission::create(['name' => 'create-claficacionpago']);
        Permission::create(['name' => 'read-claficacionpagos']);
        Permission::create(['name' => 'update-claficacionpago']);
        Permission::create(['name' => 'delete-claficacionpago']);

        //SEDE
        Permission::create(['name' => 'create-sede']);
        Permission::create(['name' => 'read-sedes']);
        Permission::create(['name' => 'update-sede']);
        Permission::create(['name' => 'delete-sede']);

        //AUTORIZACION
        Permission::create(['name' => 'create-autorizacion']);
        Permission::create(['name' => 'read-autorizaciones']);
        Permission::create(['name' => 'update-autorizacion']);
        Permission::create(['name' => 'delete-autorizacion']);

        //TIPO AUTORIZACION
        Permission::create(['name' => 'create-tipoautorizacion']);
        Permission::create(['name' => 'read-tipoautorizaciones']);
        Permission::create(['name' => 'update-tipoautorizacion']);
        Permission::create(['name' => 'delete-tipoautorizacion']);

        /*Permission::create(['name' => 'create permission']);
        Permission::create(['name' => 'read permissions']);
        Permission::create(['name' => 'update permission']);
        Permission::create(['name' => 'delete permission']);*/

        // create roles and assign created permissions

        $role = Role::create(['name' => 'editor']);
        $role->givePermissionTo('read-users');
        $role->givePermissionTo('update-user');

        $role = Role::create(['name' => 'moderador']);
        $role->givePermissionTo('create-user');
        $role->givePermissionTo('read-users');
        $role->givePermissionTo('update-user');
        $role->givePermissionTo('delete-user');

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
    }
}
