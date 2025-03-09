import { Component } from '@angular/core';
import { CommonModule } from '@angular/common'; // Import this

@Component({
  selector: 'app-login',
  standalone: true,  // Remove if using `@NgModule`
  imports: [CommonModule], // Add CommonModule here
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {
  username: string = '';
  password: string = '';
  errorMessage: string = '';
  successMessage: string = '';

  onLogin() {
    if (this.username === 'admin' && this.password === 'password') {
      this.successMessage = 'Login successful!';
      this.errorMessage = '';
    } else {
      this.errorMessage = 'Invalid username or password';
      this.successMessage = '';
    }
  }
}
