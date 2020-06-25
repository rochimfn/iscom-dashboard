<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            
            if(Auth::user()->user_role_id == 1)
            {
                $adminMenu = [
                    ['header' => 'MAIN NAVIGATION'],
                    [
                        'text'        => 'All Pages',
                        'url'         => 'dashboard/pages',
                        'icon'        => 'far fa-fw fa-file-alt',
                        'active'      => ['dashboard/pages', 'dashboard/pages*/edit']
                    ],
                    [
                        'text'        => 'Add Pages',
                        'url'         => 'dashboard/pages/create',
                        'icon'        => 'far fa-fw fa-file',
                    ],
                    [
                        'text'        => 'Participant List',
                        'url'         => '/dashboard/users',
                        'icon'        => 'fa fa-fw fa-users',
                    ],
                    [
                        'text'        => 'Evaluator List',
                        'url'         => '/dashboard/users/dosen',
                        'icon'        => 'fa fa-fw fa-users',
                    ],
                    [
                        'text'        => 'Competition Session',
                        'url'         => '/dashboard/session',
                        'icon'        => 'fa fa-fw fa-calendar',
                    ],
                    ['header' => 'account_settings'],
                    [
                        'text'        => 'profile',
                        'url'         => '/dashboard/settings',
                        'icon'        => 'fa fa-fw fa-user',
                    ],
                    [
                        'text' => 'change_password',
                        'url'  => '/dashboard/password/change',
                        'icon' => 'fas fa-fw fa-lock',
                    ],
                ];

                foreach ($adminMenu as $menu) {
                    $event->menu->add($menu);
                }

            } elseif (Auth::user()->user_role_id == 2)
            {
                $participantMenu = [
                    ['header' => 'MAIN NAVIGATION'],
                    [
                        'text'        => 'Team Member',
                        'url'         => '/home/members',
                        'icon'        => 'fa fa-fw fa-user-friends',
                    ],
                    ['header' => 'account_settings'],
                    [
                        'text'        => 'profile',
                        'url'         => '/home/settings',
                        'icon'        => 'fa fa-fw fa-user',
                    ],
                    [
                        'text'        => 'change_password',
                        'url'         => '/home/password/change',
                        'icon'        => 'fas fa-fw fa-lock',
                    ],
                ];

                foreach ($participantMenu as $menu) {
                    $event->menu->add($menu);
                }

            } elseif (Auth::user()->user_role_id == 3)
            {
                $dosenMenu = [
                    ['header' => 'MAIN NAVIGATION'],
                    
                    ['header' => 'account_settings'],
                    [
                        'text' => 'profile',
                        'url'  => '/home/dosen/settings',
                        'icon' => 'fa fa-fw fa-user',
                    ],
                    [
                        'text' => 'change_password',
                        'url'  => '/home/dosen/password/change',
                        'icon' => 'fas fa-fw fa-lock',
                    ],              
                ];

                foreach ($dosenMenu as $menu) {
                    $event->menu->add($menu);
                }
            
            }
            
            $contekan = [
                [
                    'text'    => 'multilevel',
                    'icon'    => 'fas fa-fw fa-share',
                    'submenu' => [
                        [
                            'text' => 'level_one',
                            'url'  => '#',
                        ],
                        [
                            'text'    => 'level_one',
                            'url'     => '#',
                            'submenu' => [
                                [
                                    'text' => 'level_two',
                                    'url'  => '#',
                                ],
                                [
                                    'text'    => 'level_two',
                                    'url'     => '#',
                                    'submenu' => [
                                        [
                                            'text' => 'level_three',
                                            'url'  => '#',
                                        ],
                                        [
                                            'text' => 'level_three',
                                            'url'  => '#',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'text' => 'level_one',
                            'url'  => '#',
                        ],
                    ],
                ],
                ['header' => 'labels'],
                [
                    'text'       => 'important',
                    'icon_color' => 'red',
                    'url'        => '#',
                ],
                [
                    'text'       => 'warning',
                    'icon_color' => 'yellow',
                    'url'        => '#',
                ],
                [
                    'text'       => 'information',
                    'icon_color' => 'cyan',
                    'url'        => '#',
                ]
            ];
        });
    }
}
