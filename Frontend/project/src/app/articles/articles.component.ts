import { Component, OnInit } from '@angular/core';
import { ApiService } from '../Services/api.service';
import { articlemodel } from './article.model';

@Component({
  selector: 'app-articles',
  templateUrl: './articles.component.html',
  styleUrls: ['./articles.component.css']
})
export class ArticlesComponent implements OnInit {
  public ListArticles: any = [];
  constructor(private _ApiService: ApiService) { }
 

  ngOnInit(): void {
    this.getAllArticles();
  }
  public getAllArticles(){
    this._ApiService.allarticles().subscribe((res) => (this.ListArticles = res));
  
  }
}
