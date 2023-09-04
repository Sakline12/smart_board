import { Component, Input } from '@angular/core';

@Component({
  selector: 'app-sidenav',
  templateUrl: './sidenav.component.html',
  styleUrls: ['./sidenav.component.css']
})
export class SidenavComponent {
  @Input() isSideNavOpen: boolean = true;
  @Input() sidebarWidth: number = 200;
  @Input() sidebarLeft: number = 0;
}
