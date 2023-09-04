import { Component, HostListener } from '@angular/core';
import { NavigationEnd, Router } from '@angular/router';
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'Admin';
  isSideNavOpen: boolean = true;
  sidebarWidth: number = 200; 
  sidebarLeft: number = 0;    
  mainMargin: number = 200;   
  showHeader: boolean = false;

  constructor(private router: Router) {
    this.router.events.subscribe(event => {
      if (event instanceof NavigationEnd) {
        this.showHeader = !event.url.includes('/login');
      }
    });
  }
  onRouterOutletActivate(component: any) {
    // Detect if the current component is the login component
    if (component.constructor.name === 'LoginComponent') {
      this.showHeader = false;
      this.isSideNavOpen = false;
    } else {
      this.showHeader = true;
      this.isSideNavOpen = true;
    }
  }

  @HostListener('window:resize', ['$event'])
  onResize(event: any) {
    this.checkScreenWidth();
  }

  ngOnInit() {
    this.checkScreenWidth();
  }
  checkScreenWidth() {
    this.isSideNavOpen = window.innerWidth > 768; 
    if (this.isSideNavOpen) {
      this.sidebarWidth = 200;
      this.mainMargin = 200;
    } else {
      this.sidebarWidth = 0;
      this.mainMargin = 0;
    }
  }

  toggleSideNav() {
    this.isSideNavOpen = !this.isSideNavOpen;

    if (this.isSideNavOpen) {
      this.sidebarWidth = 200;
      this.sidebarLeft = 0;
      this.mainMargin = 200;
    } else {
      this.sidebarWidth = 78;
      this.sidebarLeft = -5;
      this.mainMargin = 73;
    }
  }
}
