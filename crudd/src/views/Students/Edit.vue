<template>
    
    <div class="container mt-5">
        <div class="card">
            <div class="class-header">
                <h4> Edit Students</h4>
            </div>
            <div class="card-body">

                <ul class="alert alert-warning" v-if="Object.keys(this.errorList).length > 0">
                    <li class="mb-0 ms-3" v-for="(error, index) in this.errorList" :key="index">
                        {{ error[0] }}
                    </li>
                </ul>
                <div class="mb-3" >
                    <label for="">Name</label>
                    <input type="text" v-model="model.student.name"  class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Course</label>
                    <input type="text" v-model="model.student.course" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Email</label>
                    <input type="text" v-model="model.student.email" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Phone</label>
                    <input type="text" v-model="model.student.phone" class="form-control" />
                </div>
                <div class="mb-3">
                    <button type="button" @click="updateStudent" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default{
    name: 'studentEdit',
    data(){
        return{
            studentId : '',
            errorList: [],
            model: {
                student: {
                    name: '',
                    course:'',
                    email:'',
                    phone:''
                }
            }
        }
    },
    mounted(){
        //console.log('test std',this.model.student);
        //console.log(this.$route.params.id);
        this.studentId=this.$route.params.id;

        this.getStudentData(this.$route.params.id);
    },
    methods:{

        async getStudentData(studentId){

            const response = await axios.get(`http://127.0.0.1:8000/api/students/${studentId}/edit`)
           
                    console.log(response.data.data);

                    this.model.student = response.data.data
                    
                            if(response.status== 404){
                                alert(error.response.data.message)
                            }
                            //console.log(error.response.data);
                            //console.log(error.response.status);
                            //console.log(error.response.headers);
                        

        },
        updateStudent(){
            var mythis = this;
            axios.put(`http://127.0.0.1:8000/api/students/${this.studentId}/edit`, this.model.student)
            .then(res => {
                console.log(res.data)
                alert(res.data.message)

                
                this.errorList = '';
                if(res.status==200)
            {
                this.$router.push({name:'students'})
            }   
                
            })
            .catch(function (error){

                if(error.response){
                    if(error.response.status== 422){
                        mythis.errorList = error.response.data.errors;
                    }

                    if(error.response.status== 404){
                        alert(error.response.data.message);
                    }
                    //console.log(error.response.data);
                    //console.log(error.response.status);
                    //console.log(error.response.headers);
                }else if (error.request){
                    console.log(error.request);
                } else {
                    console.log('Error', error.message);
                }
            });
        }
    }
}
</script>
