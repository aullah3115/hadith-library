import store from '../store/index';

export default class Alert
{
  constructor(){

  }

  static dispatch(message, type){
    let data = {
      message,
      type,
    }
    store.dispatch('alert/setAlert', data);
  }
}
