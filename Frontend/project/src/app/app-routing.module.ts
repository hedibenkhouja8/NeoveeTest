import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ArticlesComponent } from './articles/articles.component';

import { HomeComponent } from './home/home.component';
import { NotfoundComponent } from './notfound/notfound.component';
import { ArticleByUserComponent } from './article-by-user/article-by-user.component';
import {AuthGuard} from './auth.guard';
import {UserGuard} from './user.guard';

const routes: Routes = [  { path: 'articles', component: ArticlesComponent ,canActivate : [AuthGuard] },
{ path: '', component: HomeComponent },
{ path: 'articles/:id', component: ArticleByUserComponent,canActivate : [AuthGuard,UserGuard] },







{ path: '**', component: NotfoundComponent},];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
  declarations: [
    NotfoundComponent
  ]
})
export class AppRoutingModule { }