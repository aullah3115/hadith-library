import Alert from '../../classes/alert';

/**
 * This is the ... module.
 */

export default {

  namespaced: true,

  /**
   * Data for this module
   */

  state: {

    narrator: null,
    narrators: null,
    teachers: null,
    students: null,
    selected_teacher: null,
    selected_student: null,
    narrations: null,
    all_narrations: null,

  },

  /**
   * Mutations for this module. This are used to commit changes to the module
   * state.
   */

  mutations: {

    storeNarrators(state, data){
      state.narrators = data;
    },

    storeNarrator(state, narrator){
      state.narrator = narrator;
    },

    storeTeachers(state, teachers){
      state.teachers = teachers;
    },

    storeStudents(state, students){
      state.students = students;
    },

    addNarrator(state, data){
      if(!state.narrator){
        state.narrator = [];
      }
      state.narrators.push(data);
    },

    selectStudent(state, student){
      state.selected_student = student;
    },

    selectTeacher(state, teacher){
      state.selected_teacher = teacher;
    },

    storeNarrations(state, narrations){
      state.narrations = narrations;
    },

    removeNarrations(state){
      state.narrations = null;
    },

    storeAllNarrations(state, narrations){
      state.all_narrations = narrations;
    },

  },

  /**
   * Actions for this module. These are asynchronus and are used for ajax
   * calls, as well as to trigger mutations
   */

  actions: {
    getAll: function({dispatch, commit, state}, data){

      if(state.narrators){
        return;
      }

      axios.get('/vue/narrators')
      .then( ({data}) => {
        commit('storeNarrators', data.narrators);
      })
      .catch( ({response}) => {

        Alert.dispatch(response.data.message, 'error');

      });
    },

    getNarratorById: function({dispatch, commit}, id){
      axios.get('/vue/narrators/narrator/' + id)
      .then( ({data}) => {
        commit('storeNarrator', data.narrator);
      })
    },

    getTeachers: function({dispatch, commit}, id){
      axios.get('/vue/teachers/for/narrator/' + id)
      .then( ({data}) => {
        commit('storeTeachers', data.teachers);
      })
    },

    getStudents: function({dispatch, commit}, id){
      axios.get('/vue/students/for/narrator/' + id)
      .then( ({data}) => {
        commit('storeStudents', data.students);
      })
    },

    addNarrator: function({dispatch, commit}, data){

      axios.post('/vue/narrator/create', data)
      .then( ({data}) => {
        commit('addNarrator', data.narrator);
        dispatch('modal/hide', 'addNarrator', {root: true});

        Alert.dispatch('Successfully added new narrator', 'success');

      })
      .catch(({response}) => {

        Alert.dispatch(response.data.message, 'error');

      });

    },

    getNarrations: function({dispatch, commit, state}, data){
      if(state.selected_student && state.selected_teacher && state.selected_student.id == data.student.id && state.selected_teacher.id == data.teacher.id){
        return;
      }

      commit('selectStudent', data.student);
      commit('selectTeacher', data.teacher);
      commit('removeNarrations');

      axios.get('/vue/narrations/of/' + data.student.id + '/from/' + data.teacher.id, data)
      .then( ({data}) => {
        commit('storeNarrations', data.narrations);
      })
    },

    getAllNarrations: function({dispatch, commit, state}, narrator_id){
      axios.get('/vue/narrations/for/narrator/' + narrator_id)
      .then( ({data}) => {
        commit('storeAllNarrations', data.narrations);
      })
    },

  },
}
