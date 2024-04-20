<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>
                    students
                    <router-link to="/students/create" class="btn btn-primary float-end">
                        Add student
                    </router-link>
                </h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="this.students.length > 0">
                        <tr v-for="(student, index) in this.students" :key="index">
                            <td>{{ student.id }}</td>
                            <td>{{ student.name }}</td>
                            <td>{{ student.course }}</td>
                            <td>{{ student.email }}</td>
                            <td>{{ student.phone }}</td>
                            <td>{{ student.created_at }}</td>
                            <td>
                                <router-link :to="{ path: '/students/'+student.id+'/edit'}" class="btn btn-success">Edit</router-link>
                                <button type="button" @click="deleteStudent(student.id)" class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="7">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
      
    
  </template>
<script>
import axios from 'axios';
export default{
    name: 'students',
    data(){
        return{
            students: []
        }
    },
    mounted(){
       this.getStudents();
        // console.log('I am here')
    
    },
    methods: {
        getStudents(){
            axios.get('http://127.0.0.1:8000/api/students/').then(res=> {
                this.students = res.data.students;
                //console.log(res)
            });
        },
        deleteStudent(StudentId){
            if(confirm('Are you sure, you want to delete this date?')){
                //console.log(StudentId)
                axios.delete(`http://127.0.0.1:8000/api/students/${StudentId}/delete`)
                .then(res => {
                    alert(res.data.message);
                    this.getStudents();
                })
                .catch(function(error) {
                    if (error.response){
                        if(error.response.status ==404){
                            alert(error.response.data.message);
                        }
                    }
                });
            }
        },
        
    }
}
</script>
  
  