import Vue from 'vue';
import VueRouter from 'vue-router';
import App from './components/App';
import ExampleComponent from './components/ExampleComponent';
import ContactCreate from './views/ContactCreate';
import ContactShow from './views/ContactShow';
import ContactEdit from './views/ContactEdit';
import ContactsList from './components/ContactsList';
import BirthdaysIndex from './views/BirthdaysIndex'
import ContactsIndex from './views/ContactsIndex'
import Logout from './actions/Logout'

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        
        
        { 
            path:'/' ,component: ExampleComponent
            ,meta:{title:'Welcome'}
        },{ 
            path:'/contacts' ,component: ContactsIndex
            ,meta:{title:'Contacts'}
        },{ 
            path:'/contacts/create' ,component: ContactCreate
            ,meta:{title:'Add New Contact'}
        },{ 
            path:'/contacts/:id' ,component: ContactShow
            ,meta:{title:'Contact Details'}
        },{ 
            path:'/contacts/:id/edit' ,component: ContactEdit
            ,meta:{title:'Edit Contact'}
        },{ 
            path:'/birthdays' ,component: BirthdaysIndex
            ,meta:{title:'This Month\'s Birthdays'}
        },{
            path:'/logout' ,component: Logout
        }
],
    mode: 'history'
});