<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
            <div class="card card-widget widget-user mt-3">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header text-white" style="background: url('/img/background-profile.jpg') center center;">
                <h3 class="widget-user-username">{{name}}</h3>
                <h5 class="widget-user-desc">{{type}}</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle" src="" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">3,200</h5>
                      <span class="description-text">SALES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">13,000</h5>
                      <span class="description-text">FOLLOWERS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">35</h5>
                      <span class="description-text">PRODUCTS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- //////////////////////////////////////////////////////////////////////////////// ////////////////////////////////////////////////////////////////////////////////-->
            <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
            <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
            </div>
            <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active show" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active show" id="activity">
                        <h2>ТУТ щось буде</h2>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="userName" placeholder="Name" v-model='name'>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="userEmail" placeholder="Email"  v-model='email'>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="userPassword" placeholder="Password"  v-model='password'>
                        </div>
                      </div>

                    <div class="form-group">
                        <label for="photo" class="col-sm-3 control-label">Change Profile Photo</label>
                        <div class="col-sm-12">
                            <input type="file" name="photo" @change="updateProfile" class="form-input">
                        </div>
                    </div>

                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" @click.prevent="updateInfo" class="btn btn-success">Update Profile</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user_id: user.id,
                name : user.name,
                email : user.email,
                type : user.type,
                password : user.password,
                photo: 'profile.png'
            }
        },
        methods: {
            updateProfile(e) {
                let file = e.target.files[0];
                let reader = new FileReader();
                if(file['size'] < 2111775){
                    reader.onloadend = (file) => {
                        this.photo = reader.result;
                    }
                }
                else{
                    swal('Fail!', 'You have exceeded the maximum size of file. Maximum size is 2 MB', 'warning')
                }
                reader.readAsDataURL(file);

            },
            updateInfo(){
                axios.put('api/profile/', {id:user.id, name:this.name, email:this.email, photo:this.photo, type:this.type, password:this.password})
                .then(()=>{
                    console.log("Profile Updated")
                })
            }
        },
        created() {
            axios.get('api/profile/')
                    .then((res)=>{
                    console.log(res.data)
                }).catch(()=>{
                    swal('Fail!', 'Something Wrong.', 'warning')
                })
            }

    }
</script>
