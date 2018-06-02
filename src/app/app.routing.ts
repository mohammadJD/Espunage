import {NgModule} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';

// Layouts
import {P404Component} from './pages/404.component';

import {AuthGuard} from './models/auth.guard';
import {AppComponent} from './app.component';
import {HomeComponent} from './pages/home.component';
import {DashboardComponent} from './dashboard/dashboard.component';
import {LoginComponent} from './auth/login/login.component';
import {LogoutComponent} from './auth/logout/logout.component';
import {SignupComponent} from './auth/signup/signup.component';
import {SimpleLayoutComponent} from "./layouts/simple-layout.component";
import {FullLayoutComponent} from "./layouts/full-layout.component";

export const routes: Routes = [
    {
        path: '',
        component: FullLayoutComponent,
        children: [
            {
                path: '',
                component: HomeComponent,
                pathMatch: 'full',
            },
        ],
    },
    {
        path: 'auth',
        component: SimpleLayoutComponent,
        children: [
            {
                path: 'login',
                component: LoginComponent,
            },
            {
                path: 'logout',
                component: LogoutComponent,
            },
            {
                path: 'register',
                component: SignupComponent,
            }
        ],
        data: {
            title: 'Home'
        },
    },
    {
        path: 'dashboard',
        component: DashboardComponent,
        canActivate: [AuthGuard],
    },
    // otherwise redirect to home
    { path: '**', component: P404Component }
];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule]
})
export class AppRoutingModule {
}
