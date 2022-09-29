import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ArticleByUserComponent } from './article-by-user.component';

describe('ArticleByUserComponent', () => {
  let component: ArticleByUserComponent;
  let fixture: ComponentFixture<ArticleByUserComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ArticleByUserComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ArticleByUserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
