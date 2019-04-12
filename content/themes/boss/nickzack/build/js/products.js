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
      {"type":null}
      ],
      filterListTypes:['type']
  
    }
  },
  methods:{
    filter(filterType,filter){
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
          for(product of postsToFilter){
            let productType = product.plantType.toLowerCase();
            if(productType === typeName){
              this.posts.push(product);
            }
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