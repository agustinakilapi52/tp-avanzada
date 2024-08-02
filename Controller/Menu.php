<?php
class Menu
{
    public function buscarMenus($param = NULL)
    {
        $objMenu = new Model_menu();
        $where = " true";

        if (isset($param['idmenu'])) {
            $where .= " AND idmenu = " . $param['idmenu'];
        }
        if (isset($param['menombre'])) {
            $where .= " AND menombre = '" . $param['menombre'] . "'";
        }
        if (isset($param['medescripcion'])) {
            $where .= " AND medescripcion = '" . $param['medescripcion'] . "'";
        }
        if (isset($param['idpadre'])) {
            $where .= " AND idpadre = " . $param['idpadre'];
        }
        if (isset($param['medeshabilitado'])) {
            $where .= " AND medeshabilitado = " . $param['medeshabilitado'];
        }

        $menu = $objMenu->Listar($where);

        return $menu;
    }

    public function getRolesParaMenu($id_roles = [], $superadmin = 0)
    {
        $objMenuRol = new Model_menurol();
        $menu = [];
        if (count($id_roles) > 0) {
            // Si el ROL 1 (ADMIN) esta en el arreglo de $id_roles, entonces se le muestran todos los menus
            if (in_array(1, $id_roles)) {
                $where = ' true GROUP BY idmenu';
                $lista_objMenu = $objMenuRol->Listar($where);
                foreach ($lista_objMenu as $l) {
                    if ($l->getObjMenu()->getMeDeshabilitado() == '0000-00-00 00:00:00' || $l->getObjMenu()->getMeDeshabilitado() == NULL) {
                        $menu[] = [
                            'idmenu' => $l->getObjMenu()->getIdMenu(),
                            'nombre' => $l->getObjMenu()->getMeNombre(),
                            'id_padre' => $l->getObjMenu()->getIdPadre(),
                            'descripcion' => $l->getObjMenu()->getMeDescripcion(),
                        ];
                    }
                }
            } else {
                foreach ($id_roles as $id) {
                    $where = 'idrol = ' . $id;
                    $lista_objMenu = $objMenuRol->Listar($where);
                    foreach ($lista_objMenu as $l) {
                        if ($l->getObjMenu()->getMeDeshabilitado() == '0000-00-00 00:00:00' || $l->getObjMenu()->getMeDeshabilitado() == NULL) {
                            $menu[] = [
                                'idmenu' => $l->getObjMenu()->getIdMenu(),
                                'nombre' => $l->getObjMenu()->getMeNombre(),
                                'id_padre' => $l->getObjMenu()->getIdPadre(),
                                'descripcion' => $l->getObjMenu()->getMeDescripcion(),
                            ];
                        }
                    }
                }
            }
        } else {
            $where = 'idrol = ' . 3;
            $lista_objMenu = $objMenuRol->Listar($where);
            foreach ($lista_objMenu as $l) {
                if ($l->getObjMenu()->getMeDeshabilitado() == '0000-00-00 00:00:00' || $l->getObjMenu()->getMeDeshabilitado() == NULL) {
                    $menu[] = [
                        'idmenu' => $l->getObjMenu()->getIdMenu(),
                        'nombre' => $l->getObjMenu()->getMeNombre(),
                        'id_padre' => $l->getObjMenu()->getIdPadre(),
                        'descripcion' => $l->getObjMenu()->getMeDescripcion(),
                    ];
                }
            }
        }

        $resultado = $this->menuArray($menu);
        return $resultado;
    }

    protected function menuArray($menu, $padre = NULL)
    {
        $resultado = [];
        $hijos = [];

        for ($i = 0; $i < count($menu); $i++) {
            if ($menu[$i]['id_padre'] == $padre) {
                $hijos[] = $menu[$i];
            }
        }

        if ($hijos) {

            for ($i = 0; $i < count($hijos); $i++) {
                $hijo = $hijos[$i];
                $hijo['children'] = [];
                $arreglo_de_hijos = $this->menuArray($menu, $hijo['idmenu']);
                if ($arreglo_de_hijos) {
                    $hijo['children'] = $arreglo_de_hijos;
                }
                $resultado[] = $hijo;
            }
        } else {
            $resultado = false;
        }

        return $resultado;
    }

    public function estructuraMenu($menu) {
        $html = '';
        if (empty($menu)) {
            return $html;
        }
        foreach ($menu as $m) {
            $id_padre = $m['id_padre'];
            $tiene_padre = $id_padre != NULL ? true : false;
            $nombre = $m['nombre'];
            if ($tiene_padre) {
                $html .= '<li><a class="dropdown-item" href="#">' . $nombre . '</a></li>';
            } else {
                if (isset($m['children'])) {
                    $html .= '<div class="dropdown">';
                    $html .= '<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">' . $nombre . '</button>';
                    $html .= '<ul class="dropdown-menu">';
                    $html .= $this->estructuraMenu($m['children']);
                    $html .= '</ul>';
                    $html .= '</div>';
                } else {
                    $html .= '<li><a class="dropdown-item" href="#">' . $nombre . '</a></li>';
                }
            }
        }
        return $html;
    }

    
 
    public function getAllMenus()
    {
        $objMenu = new Model_menu();
        $menus = $objMenu->Listar();
        return $menus;
    }

    public function getMenusHistorico()
    {
        $listaMenus = $this->buscarMenus();
        $menus = [];
        foreach ($listaMenus as $value) {

            if ($value->getIdPadre() == NULL) {
                $menus[] = [
                    'idmenu' => $value->getIdMenu(),
                    'menombre' => $value->getMeNombre(),
                    'medescripcion' => $value->getMeDescripcion(),
                    'menu_padre' => '-',
                    'estado' => $value->getMeDeshabilitado(),
                ];
            } else {

                $param['idmenu'] = $value->getIdPadre();
                $menu = $this->buscarMenus($param);

                $menus[] = [
                    'idmenu' => $value->getIdMenu(),
                    'menombre' => $value->getMeNombre(),
                    'medescripcion' => $value->getMeDescripcion(),
                    'menu_padre' => $menu[0]->getMeNombre(),
                    'estado' => $value->getMeDeshabilitado(),
                ];
            }
        }

        return $menus;
    }

public function getDataMenuEdit($id_menu)
{
        $parametros = [];
        $parametros['idmenu'] = $id_menu;

        $menues = $this->buscarMenus($parametros);
        $objRol = new Rol();

        $roles_menu = $objRol->getAllRolesMenu($id_menu);

        $data_menu = [];
        foreach ($menues as $value) {
            $data_menu[] = [
                'idmenu' => $value->getIdMenu(),
                'menombre' => $value->getMeNombre(),
                'medescripcion' => $value->getMeDescripcion(),
                'id_padre' => $value->getIdPadre(),
                'roles' => $roles_menu
            ];
        }

        return $data_menu;
    }



 public function crearMenu($datos) {
        $objMenu = new Model_menu();
        
        if (isset($datos)) {
            $objMenu->setearValores(null, $datos['menombre'], $datos['medescripcion'], $datos['idpadre'], null);
    
            $verificacion = $objMenu->Insertar();
    
            if ($verificacion) {
                $Rol = new Rol();
                $Menu = new Menu();
    
                $param_menu['menombre'] = $datos['menombre'];
                $menus = $Menu->buscarMenus($param_menu);
    
                if (empty($menus)) {
                    return $this->responseError('No se encontró el menú');
                }
    
                $obj_menu = $menus[0];
    
                foreach ($datos['roles'] as $role) {
                    $param_rol['idrol'] = intval($role);
                    $roles = $Rol->buscarRol($param_rol);
    
                    if (empty($roles)) {
                        error_log('Rol no encontrado: ' . $role);
                        continue;
                    }
    
                    $obj_rol = $roles[0];
                    $resultado = $Rol->insertarRolesMenu($obj_menu, $obj_rol);
    
                    if (!$resultado) {
                        error_log('Error al asignar el rol ID ' . $role . ' al menú ' . $param_menu['menombre']);
                    }
                }
    
                $resultado = ['exito' => true];
                echo json_encode($resultado);
            } else {
                return $this->responseError('¡Error al insertar el menú!');
            }
        }
    }
    


private function responseError($message) {
    http_response_code(400);
    echo json_encode(['error' => $message]);
    exit();
}

}
