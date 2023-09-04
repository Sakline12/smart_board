import { Component, EventEmitter, Input, Output, OnInit } from '@angular/core';
import { ActivatedRoute, NavigationEnd, Router } from '@angular/router';
import { filter } from 'rxjs/operators'
@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit{
  @Input() mainMargin: number = 200;
  @Output() toggleSideNavEvent = new EventEmitter<void>();
  routeTitle: string = '';
  constructor(private router: Router, private route: ActivatedRoute) {}

  ngOnInit() {
    // Subscribe to the NavigationEnd event to update routeTitle
    this.router.events
      .pipe(filter(event => event instanceof NavigationEnd))
      .subscribe(() => {
        const title = this.route.snapshot.firstChild?.data['title'];
        if (title) {
          this.routeTitle = title;
        }
      });
  }
  toggleSideNav() {
    this.toggleSideNavEvent.emit();
  }
  isDropdownOpen: boolean = false;

  openDropdown() {
    this.isDropdownOpen = true;
  }

  closeDropdown() {
    this.isDropdownOpen = false;
  }
}
