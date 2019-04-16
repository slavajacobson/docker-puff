jQuery(document).ready(function($){
new Vue({
  el: '.products',
  data () {
    return {
      posts: [],
      page: 1,
      perPage: 9,
      pages: [],
      filterList: [
      {"type":null},
      {"category":null}
      ],
      filterListTypes:['type','category']
  
    }
  },
  methods:{
    filter(filterType,filter,event,typeOfFilter){
      let target = $(event.target);
      if(!target.hasClass("active-filter") && typeOfFilter === 'button'){
        target.parent().find("span").removeClass("active-filter");
        target.addClass("active-filter");
      }
      let filterArray = {"filterType":filterType,"filter":filter};
      this.filterList[0][filterType] = filter;
    },
    filterResults(){
      this.getPosts(this.filterList);
    },
    getPosts(filters){
      if(filters =='none'){
      axios.get('/wp-json/product/all-products').then(response => {
        this.posts = response.data;
        //console.log(response.data);
        
      }).catch(e =>{
        this.errors.push(e);
      })
    }
    else{
      this.posts = [];
      this.pages = [];
      axios.get('/wp-json/product/all-products').then(response => {
        let filterList = filters[0];
        let activeFilters = [];
        for(filterType of this.filterListTypes){
          let name = filterType;
          if(filterList[filterType] !== null){
            let newArray = {[filterType]:filterList[filterType]};
            activeFilters.push(newArray);
          }
        }

        if(activeFilters[0] === undefined){
            console.log('no filters selected!');
            this.posts = response.data;
        }
        else{
          let postsToFilter = response.data;
          //filter by type
          let typeName = activeFilters[0]['type'];
          let categoryName = activeFilters[0]['category'];
          for(product of postsToFilter){
            //check type
            if(typeName !== undefined){
              let productType = product.plantType.toLowerCase();
              if(productType === typeName){
                this.posts.push(product);
              }
              if(typeName === 'all'){
                this.posts.push(product);
              }
            }
            //end check type
            //check category
            if(categoryName !== undefined){
              let productCategory = product.plantCategory.toLowerCase();
              if(productCategory === categoryName){
                this.posts.push(product);
              }
              if(productCategory === 'all'){
                this.posts.push(product);
              }
            }
            //end check category
          }
        }

        
      }).catch(e =>{
        console.error(e);
      })
    }
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
        this.getPosts('none');
        
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

      },
      findLength: function(value){
        let amountOfReviews = 0;
        for(val of value){
          let replyCheck = val.reply;
          if(!replyCheck){
            amountOfReviews++;
          }
        }
        return amountOfReviews;
      }
    }
})
})