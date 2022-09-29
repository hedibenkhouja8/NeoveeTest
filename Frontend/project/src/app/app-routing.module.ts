import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ArticlesComponent } from './articles/articles.component';

import { HomeComponent } from './home/home.component';
import { NotfoundComponent } from './notfound/notfound.component';

const routes: Routes = [  { path: 'articles', component: ArticlesComponent },
{ path: '', component: HomeComponent},







{ path: '**', component: NotfoundComponent},];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
  declarations: [
    NotfoundComponent
  ]
})
export class AppRoutingModule { }