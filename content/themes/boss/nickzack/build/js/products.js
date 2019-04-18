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
    imageNotLoaded: function(event){
        let thisImage = $(event.target);
        thisImage.attr('src','http://placehold.it/200x200');

        
      },
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
    getPosts(filters,preFilter){
      
      //normal page refresh load
      if(filters =='none' && preFilter === undefined){
        console.log(preFilter);
      axios.get('/wp-json/product/all-products').then(response => {
        this.posts = response.data;

      }).catch(e =>{
        this.errors.push(e);
      })
    }
    //prefilter is active (probably from homepage)
    else if(preFilter !== undefined){
      var filterName = preFilter[0];
      var filter = preFilter[1];
      axios.get('/wp-json/product/all-products').then(response => {
        let postsToFilter = response.data;
        for(product of postsToFilter){
          if(product[filterName].toLowerCase() === filter.toLowerCase()){
            this.posts.push(product);
          }
        }
      }).catch(e =>{
        this.errors.push(e);
      })
    }
    //filters selected
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
        //check if there is a prefilter already
        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
        }
        let typePreFilter = getUrlParameter('type');
        let categoryPreFilter = getUrlParameter('category');

        if(typePreFilter !== undefined || categoryPreFilter !== undefined){
          if(typePreFilter !== undefined){
            //set pre filter array [parentName,filterName]
              var preFilter = ['plantType',typePreFilter];
              this.getPosts('none',preFilter);
          }
          else if(categoryPreFilter !== undefined){
              var preFilter = ['plantCategory',categoryPreFilter];
              this.getPosts('none',preFilter);
          }
        }
        else{
          this.getPosts('none');
        }
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