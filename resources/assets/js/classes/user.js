export default class User
{
  constructor(user){
    this.id = user.id;
    this.name = user.name;
    this.email = user.email;
  }

  id(){
    return this.id;
  }

  name(){
    return this.name;
  }

  email(){
    return this.email;
  }

}
