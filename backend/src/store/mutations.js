
export function setUser(state, user) {
  state.user.data = user;
}

export function setToken(state, token) {
  state.user.token = token;
  if (token) {
    sessionStorage.setItem('TOKEN', token);
  } else {
    sessionStorage.removeItem('TOKEN')
  }
}

export function setCompanies(state,[loading,response=null]){
  if (response){
    state.companies = {
      data:response.data,
      links:response.meta.links,
      total:response.meta.total,
      limit:response.meta.per_page,
      from:response.meta.from,
      to:response.meta.to,
      page:response.meta.current_page,
    }
  }
  state.companies.loading = loading;
}


export function setEmployee(state,[loading,response=null]){
  if (response){
    state.employee = {
      data:response.data,
      links:response.meta.links,
      total:response.meta.total,
      limit:response.meta.per_page,
      from:response.meta.from,
      to:response.meta.to,
      page:response.meta.current_page,
    }
  }
  state.companies.loading = loading;
}
