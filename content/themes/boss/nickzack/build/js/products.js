jQuery(document).ready(function($){

new Vue({
  el: '.products',
  data () {
    return {
      posts: [],
      page: 1,
      perPage: 9,
      pages: [],
  
    }
  },
  methods:{
    getPosts(){
      axios.get('http://localhost/wp-json/product/all-products').then(response => {
        this.posts = response.data;
        console.log(response.data);
        
      }).catch(e =>{
        this.errors.push(e);
      })

    },
    setPages(){
      let numberOfPages = Math.ceil(this.posts.length / this.perPage);
            for (let index = 1; index <= numberOfPages; index++) {
              this.pages.push(index);
            }


    },
    paginate (posts) {
      let page = this.page;
      let perPage = this.perPage;
      let from = (page * perPage) - perPage;
      let to = (page * perPage);
      return  posts.slice(from, to);
    },
    checkEmptyImages(){
     setTimeout(function(){


      $(".product").each(function(){
      let container = $(this).find(".product-image");
      let thisImage = $(this).find(".product-image img");
      let image = thisImage.attr("src");
      $.get(image)
          .done(function() { 
              

          }).fail(function() { 
              // Image doesn't exist - do something else.
          thisImage.attr("src","https://via.placeholder.com/200");
          container.addClass("no-image");
          
          })
      });
       },200);
    }
  },
    computed: {
        displayedPosts () {
            return this.paginate(this.posts);
        }
    },
    watch: {
        posts () {
            this.setPages();
        }
    },
    created () {
        this.getPosts();
        
    },
    filters:{
      lowercase: function(value){
        return value.toLowerCase();
      },
      averageToPercentage: function(value){

        return value * 100 + "%";
      },
      customFilter: function(value){
        if(value == 12){
          return true;
        }
        else{
          return false;
        }

      }
    }
})
})