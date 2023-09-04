import { Component, OnInit, TemplateRef } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { DataService } from '../service/data.service';
import { BsModalRef, BsModalService } from 'ngx-bootstrap/modal';

@Component({
  selector: 'app-about',
  templateUrl: './about.component.html',
  styleUrls: ['./about.component.css']
})
export class AboutComponent implements OnInit {
  aboutUpdate = {
    id:null,
    header_title: null,
    image: null,
    background_image: null,
    description: null,
    question: null,
    button_text: null,
    button_link: null,
    is_active: null,
  };
  data: any;
  modalRef: BsModalRef<unknown> | undefined;
  routeTitle: any;
  headerTitle: any;
  image: any;
  backgroundImage: any;
  buttonText: any;
  buttonLink: any;
  description: any;
  question: any;
  isActive: any;
  status: any;
  id: any;
  headerTitleID: any;
  header_title: any;
 
  

  constructor(
    private route: ActivatedRoute,
    private dataService: DataService,
    private modalService: BsModalService
  ) {}

  ngOnInit() {
    this.route.data.subscribe(data => {
      this.routeTitle = data['title'];
    });
    this.loadAboutDetails();
  }

  openModal(template: TemplateRef<any>) {
    this.modalRef = this.modalService.show(template);
  }

  loadAboutDetails() {
    this.dataService.aboutDetails().subscribe((data: any) => {
      this.headerTitle = data.title;
      this.image = data.data.image;
      this.backgroundImage = data.data.background_image;
      this.buttonText = data.data.button_text;
      this.buttonLink = data.data.button_link;
      this.description = data.data.description;
      this.question = data.data.question;
      this.isActive = data.data.is_active;
      this.id=data.data.id;
      this.header_title = data.data.title.id;
 
      this.status = this.isActive === 1 ? 'Active' : 'Inactive';

      this.aboutUpdate = {
        header_title: this.header_title,
        image: this.image,
        background_image: this.backgroundImage,
        button_text: this.buttonText,
        button_link: this.buttonLink,
        description: this.description,
        question: this.question,
        is_active: this.isActive,
        id:this.id
      };
    });
  }

  onSubmit() {
    // Check if any fields in aboutUpdate are null or undefined
    if (this.aboutUpdate.header_title === null || this.aboutUpdate.header_title === undefined) {
      this.aboutUpdate.header_title = this.header_title;
    }
  
    if (this.aboutUpdate.image === null || this.aboutUpdate.image === undefined) {
      this.aboutUpdate.image = this.image;
    }
  
    if (this.aboutUpdate.background_image === null || this.aboutUpdate.background_image === undefined) {
      this.aboutUpdate.background_image = this.backgroundImage;
    }
  
    // Repeat this pattern for other fields...
  
    // Now you can proceed to update the data
    this.dataService.updateAbout(this.aboutUpdate).subscribe((data) => {
      this.data = data;
      console.log(this.data);
      this.modalService.hide();
    });
  }
  
}
  


