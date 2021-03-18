

new Vue({
    el: '#app',
    delimiters: ['${', '}'],
    data: function() {
        return {
            postDialogVisible: false,
            activeName: 'first',
            labelPosition: 'right',
            post_selected: {},
            is_logged: false,
            current_user: null,
            posts: [],
            post_form: {title: null, description: null},
            contact_form: {name: null, email: null, message: null},
            user_form: {name: null, email: null, password: null}
        };
    },
    mounted: function(){
        this.loadPosts();
        this.isLogged();
    },
    methods: {
        handleClick(tab, event) {
            //console.log(tab, event);
        },
        selectPost(post){
            this.post_selected = post;
        },
        loadPosts(){
            let that = this;
            axios.get('/posts/list')
                .then(function (response) {
                    that.posts = JSON.parse(response.data);
                    that.post_selected = that.posts.length > 0 ? that.posts[0] : {};
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    that.$message.error('Error');
                })
                .then(function () {
                    // always executed
                });
        },
        isLogged()  {
            let that = this;
            axios.get('/current-user')
                .then(function (response) {
                    let data = JSON.parse(response.data);
                    that.is_logged = data == null ? false : true;
                    that.current_user = data;
                })
                .catch(function (error) {
                    that.is_logged = false;
                })
                .then(function () {
                    // always executed
                });
        },
        savePost() {
            let that = this;
            axios.post('/admin/posts/createOrEdit', this.post_form)
                .then(function (response) {
                    if(that.post_form.id) {
                        for (const index in that.posts) {
                            if(that.posts[index].id ===  that.post_form.id) {
                                that.posts[index] = JSON.parse(response.data);
                            }
                        }
                    } else {
                        that.posts.unshift(JSON.parse(response.data));
                    }
                    that.postDialogVisible = false;
                    that.$message({
                        message: 'Ok',
                        type: 'success'
                    });
                })
                .catch(function (error) {
                    console.log(error);
                    that.$message.error('Error');
                });
        },
        openPostForm(post_id) {
            if (post_id !== undefined) {
                const post = this.posts.find( ({ id }) => id === post_id );
                this.post_form = {id: post.id, title: post.title, description: post.description};
            } else {
                this.post_form = {title: null, description: null};
            }

            this.postDialogVisible = true
        },
        sendContact() {
            let that = this;
            axios.post('/admin/contacts/create', this.contact_form)
                .then(function (response) {
                    that.contact_form = {name: null, email: null, message: null};
                    that.$message({
                        message: 'Ok',
                        type: 'success'
                    });
                })
                .catch(function (error) {
                    console.log(error);
                    that.$message.error('Error');
                });
        },
        sendUser() {
            let that = this;
            axios.post('/admin/users/create', this.user_form)
                .then(function (response) {
                    that.user_form = {name: null, email: null, password: null};
                    that.$message({
                        message: 'Ok',
                        type: 'success'
                    });
                })
                .catch(function (error) {
                    console.log(error);
                    that.$message.error('Error');
                });
        },
        formatDate(date) {
            var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

            if (month.length < 2)
            month = '0' + month;
            if (day.length < 2)
            day = '0' + day;

            return [year, month, day].join('-');
        }
    }
})