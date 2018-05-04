<?php
/**
 * Package: vdhoangson/permission
 * Author: vdhoangson
 * Github: https://github.com/vdhoangson/permission
 * Web: vdhoangson.com
 */

namespace vdhoangson\Permission;

use Illuminate\Support\Facades\Auth;
use DB;

class VSPermission {
    protected $permission;
    /**
     * Create a new confide instance.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    public function __construct(){
        $this->permission(Auth::user()->role_id);
    }

    public function checkAccess($route){
        if($this->permissions && in_array($route, $this->permissions)){
            return true;
        }
        return false;
    }

    private function permission($id){
        $result = DB::table('role')->where('id', $id)->first();

		if($result){
            $permissionTable = DB::table('permission')->whereIn('id', explode(',', $result->permissions))->get();
            foreach($permissionTable as $per){
                $this->permissions[] = $per->slug;
            }
        }
	}

}
