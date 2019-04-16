jQuery(document).ready(function($){
new Vue({
  el: '.page-view.homepage',
  data () {
    return {
      newestPosts: [],
    }
  },
  methods:{
    getPosts(){
      axios.get('/wp-json/carousel/all-carousels').then(response => {
        this.newestPosts = response.data[0].newest;
        let parentThis = this;
        setTimeout(function(){parentThis.swipeItUp();},1000)
        


      }).catch(e =>{
        this.errors.push(e);
      })
    },

    swipeItUp(){
       var mySwiper = new Swiper ('.swiper-container.newest-carousel', {
              // Optional parameters
              direction: 'horizontal',
              loop: true,
              spaceBetween: 15,
              slidesPerView: 5

            })
      $(".newest-navigation .previous").click(function(){
         $(".swiper-container.newest-carousel")[0].swiper.slidePrev();
      });
      $(".newest-navigation .next").click(function(){
         $(".swiper-container.newest-carousel")[0].swiper.slideNext();
      });
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