import { createPerimeter } from 'vue-kindergarten';

export default createPerimeter({
  purpose: 'auth',
  can: {
    auth() {
      return this.child;
    },
    guest() {
      if (this.child){
        return false;
      }

      return true;
    },
    superAdmin() {
      if(this.child && this.child.roles){
        let roles = this.child.roles;
        return roles.includes('super-admin');
      }
      
    }
  }
});
