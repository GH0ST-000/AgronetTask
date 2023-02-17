import axiosClient from "../axios";

export function getUser({commit}, data) {
  return axiosClient.get('/user', data)
    .then(({data}) => {
      commit('setUser', data);
      return data;
    })
}

export function login({commit}, data) {
  return axiosClient.post('/login', data)
    .then(({data}) => {
      commit('setUser', data.user);
      commit('setToken', data.token)
      return data;
    })
}

export function logout({commit}) {
  return axiosClient.post('/logout')
    .then((response) => {
      commit('setToken', null)

      return response;
    })
}

export function getCompanies({commit},{url = null,search = '',perPage= 10} = {}){
  commit('setCompanies',[true])
  url = url || '/companies';
  return  axiosClient.get(url,{
    params:{search,per_page:perPage}
  })
    .then(res => {
      commit('setCompanies',[false,res.data])
    })
    .catch(() => {
      commit('setCompanies',[false])
    })
}

export function createCompanies({commit},companies){
    if (companies.image instanceof File){
      const form =new FormData();
      form.append('name',companies.name)
      form.append('email',companies.email)
      form.append('logo',companies.image)
      form.append('website',companies.website)
      companies = form;
    }

    return axiosClient.post('/companies',companies)
}

export function updateCompanies({commit},companies){
  const id = companies.id;
  if (companies.image instanceof File){
    const form =new FormData();
    form.append('name',companies.name)
    form.append('email',companies.email)
    form.append('logo',companies.image)
    form.append('website',companies.website)
    form.append('_method','PUT')
    companies = form;
  }else {
    companies._method='PUT'
  }
  return axiosClient.post(`/companies/${id}`,companies)
}

export function getCompany({},id){
  return axiosClient.get(`/companies/${id}`)
}


export function  deleteCompanies({commit},id){
  return axiosClient.delete(`/companies/${id}`);
}



export function getEmployees({commit},{url = null,search = '',perPage= 10} = {}){
  commit('setEmployee',[true])
  url = url || '/employee';
  return  axiosClient.get(url,{
    params:{search,per_page:perPage}
  })
    .then(res => {
      commit('setEmployee',[false,res.data])
    })
    .catch(() => {
      commit('setEmployee',[false])
    })
}
export function createEmployee({commit},employee){
    return axiosClient.post('/employee',employee)
}

export function updateEmployee({commit},employee){

  const id = employee.id;
  employee._method='PUT'
  return axiosClient.post(`/employee/${id}`,employee)
}

export function getEmploy({},id){
  return axiosClient.get(`/employee/${id}`)
}

export function  deleteEmployee({commit},id){
  return axiosClient.delete(`/employee/${id}`);
}
