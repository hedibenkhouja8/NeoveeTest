import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {

  currentUserId: any;
  constructor() {
    this.currentUserId = localStorage.getItem('id'); }

  ngOnInit(): void {
  }
  logout(){
    localStorage.clear();
    
   window.location.href="/"
  }

}
