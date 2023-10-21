<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create permissions
        $permissions = [
          [
            'name' => 'Administrador',
            'display_name' => 'Administrador General',
            'group_key' => 'Global',
          ],
          [
            'name' => 'Dashboard-Estadisticas',
            'display_name' => 'Resumen de Estadisticas',
            'group_key' => 'Dashboard',
          ],
          [
            'name' => 'Dashboard-Graficos',
            'display_name' => 'Graficas',
            'group_key' => 'Dashboard',
          ],
          [
            'name' => 'Panel-Miembros',
            'display_name' => 'Miembros-dashboard',
            'group_key' => 'Dashboard',
          ],
          [
            'name' => 'Agregar-Miembro',
            'display_name' => 'Crear Miembro',
            'group_key' => 'Miembros',
          ],
          [
            'name' => 'Ver-Miembro',
            'display_name' => 'Ver Detalles',
            'group_key' => 'Miembros',
          ],
          [
            'name' => 'Editar-Miembro',
            'display_name' => 'Miembro Editado',
            'group_key' => 'Miembros',
          ],
          [
            'name' => 'Eliminar-Miembro',
            'display_name' => 'Miembro Eliminado',
            'group_key' => 'Miembros',
          ],
          [
            'name' => 'Agregar-Plan',
            'display_name' => 'Crear Plan',
            'group_key' => 'Plan',
          ],
          [
            'name' => 'Ver-Plan',
            'display_name' => 'Ver Detalles',
            'group_key' => 'Plan',
          ],
          [
            'name' => 'Editar-Plan',
            'display_name' => 'Plan Editado',
            'group_key' => 'Plan',
          ],
          [
            'name' => 'Eliminar-Plan',
            'display_name' => 'Plan Eliminado',
            'group_key' => 'Plan',
          ],
          [
            'name' => 'Agregar-Suscripcion',
            'display_name' => 'Crear Suscripcion',
            'group_key' => 'Suscripcion',
          ],
          [
            'name' => 'Ver-Suscripcion',
            'display_name' => 'Ver Detalles',
            'group_key' => 'Suscripcion',
          ],
          [
            'name' => 'Editar-Suscripcion',
            'display_name' => 'Suscripcion Editada',
            'group_key' => 'Suscripcion',
          ],
          [
            'name' => 'Renovar-Suscripcion',
            'display_name' => 'Suscripcion Renovada',
            'group_key' => 'Suscripcion',
          ],
          [
            'name' => 'Cambiar-Suscripcion',
            'display_name' => 'Actualizacion de Suscripcion',
            'group_key' => 'Suscripcion',
          ],
          [
            'name' => 'Eliminar-Suscripcion',
            'display_name' => 'Suscripcion Eliminada',
            'group_key' => 'Suscripcion',
          ],
          [
            'name' => 'Agregar-Pago',
            'display_name' => 'Pago Agregado',
            'group_key' => 'Pagos',
          ],
          [
            'name' => 'Editar-Pago',
            'display_name' => 'Pago Editado',
            'group_key' => 'Pagos',
          ],
          [
            'name' => 'Eliminar-Pago',
            'display_name' => 'Pago Eliminado',
            'group_key' => 'Pagos',
          ],
          [
            'name' => 'Ver-Recibo',
            'display_name' => 'Ver Recibo',
            'group_key' => 'Recibos',
          ],
          [
            'name' => 'Agregar-Descuento',
            'display_name' => 'Agregar Descuento',
            'group_key' => 'Recibos',
          ],
          [
            'name' => 'Imprimir-Recibo',
            'display_name' => 'Recibo Impreso',
            'group_key' => 'Recibos',
          ],
          [
            'name' => 'Eliminar-Recibo',
            'display_name' => 'Recibo Eliminado',
            'group_key' => 'Recibos',
          ],
          [
            'name' => 'Administrar-Usuarios',
            'display_name' => 'Manejo de Usuarios',
            'group_key' => 'Usuarios',
          ],
          [
            'name' => 'Administrar-Configuracion',
            'display_name' => 'Configuracion',
            'group_key' => 'Global',
          ],
          [
            'name' => 'Manejo-Servicios',
            'display_name' => 'Manejo de Servicios',
            'group_key' => 'Servicios',
          ],
          [
            'name' => 'Agregar-Servicio',
            'display_name' => 'Servicio Agregado',
            'group_key' => 'Servicios',
          ],
          [
            'name' => 'Ver-Servicio',
            'display_name' => 'Ver Detalles',
            'group_key' => 'Servicios',
          ],
          [
            'name' => 'Editar-Servicio',
            'display_name' => 'Servicio Editado',
            'group_key' => 'Servicios',
          ],
          [
            'name' => 'Eliminar-Servicio',
            'display_name' => 'Servicio Eliminado',
            'group_key' => 'Servicios',
          ],
          [
            'name' => 'Estadisticas',
            'display_name' => 'Total de Estadisticas',
            'group_key' => 'Global',
          ],
          
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
