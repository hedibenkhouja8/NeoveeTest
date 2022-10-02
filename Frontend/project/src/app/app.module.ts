import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppComponent } from './app.component';
import { NavbarComponent } from './navbar/navbar.component';
import { AppRoutingModule } from './app-routing.module';

import { HttpClientModule ,  HTTP_INTERCEPTORS } from "@angular/common/http";

import { FormsModule,ReactiveFormsModule } from '@angular/forms';
import { ArticlesComponent } from './articles/articles.component';
import { HomeComponent } from './home/home.component';
import { ApiService } from './Services/api.service';
import { FooterComponent } from './footer/footer.component';
import { ArticleByUserComponent } from './article-by-user/article-by-user.component';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';


@NgModule({
  declarations: [
    AppComponent,
    NavbarComponent,
    ArticlesComponent,
    HomeComponent,
    FooterComponent,
    ArticleByUserComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule, HttpClientModule,FormsModule,ReactiveFormsModule,NgbModule
  ],
  providers: [ ApiService],
  bootstrap: [AppComponent]
})
export class AppModule { }
