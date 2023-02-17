const store = {
  user: {
    token: sessionStorage.getItem('TOKEN'),
    data: {}
  },
  companies:{
    loading:false,
    data:[],
    links:[],
    from:null,
    to:null,
    page:1,
    limit:null,
    total:null
  },
  employee:{
    loading:false,
    data:[],
    links:[],
    from:null,
    to:null,
    page:1,
    limit:null,
    total:null
  }


};

export default store;
