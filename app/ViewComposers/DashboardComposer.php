<?php

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Users\Repository as UserRepository;
use Cartalyst\Sentinel\Sentinel;
class DashboardComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $roles;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(Sentinel $sentinel)
    {
        // Dependencies automatically resolved by service container...
        $this->roles = $sentinel->getRoleRepository();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $roles = $this->roles->all();
        $role_id = \Sentinel::getUser()->roles()->get()->first();

        $a = \DB::table('role_menus')->where('role_id', $role_id->id)->get();
        $array = array();
        foreach ($a as $key => $value) {
            array_push($array, $value->menu_id);
        }
        $menus = \DB::table('menus')->whereIn('id', $array)->get();
        
        $view->with('menus', $menus);

        
    }
}