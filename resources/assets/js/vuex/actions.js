
const  loadData =({commit}) => {
    axios.get('/api/user_data')
        .then(({data}) => {
            commit('setData', data);
        });
};
const createItem = ({commit}, itemData) => {
    commit('ajax',false);
    let data_sent = {};
    data_sent[itemData.condition] = itemData.data;
    data_sent['company_id'] = itemData.data.company_id;

    axios.post('/api/'+itemData.condition+'s/', data_sent)
        .then(({data}) => {
            commit('add'+capitalize(itemData.condition), data.data);
            commit('ajax', true);
            commit('clearErrors');
        })
        .catch(error => {
            commit('ajax', true);
            if (error.response.status === 422) {
                commit('addErrors', {data: error.response.data.errors});
            } else {
                commit('addErrors', {data: {error: ['Something went wrong. Please try again']}});
            }
        });
};
const editItem = ({commit}, itemData) => {
    commit('ajax',false);
    let data_sent = {};
    data_sent[itemData.condition] = itemData.data;
    data_sent['company_id'] = itemData.data.company_id;

    axios.patch('/api/'+itemData.condition+'s/' + itemData.data.id, data_sent)
        .then(({data}) => {
            commit('update'+capitalize(itemData.condition),data.data);
            commit('ajax', true);
            commit('clearErrors');
        })
        .catch(error => {
            console.log(error);
            commit('ajax', true);
            if (error.response.status === 422) {
                commit('addErrors', {data: error.response.data.errors});
            } else {
                commit('addErrors', {data: {error: ['Something went wrong. Please try again']}});
            }
        });
};
const deleteItem =({commit}, itemData) => {
    commit('ajax',false);
    axios.delete('/api/'+itemData.condition+'s/' + itemData.data.id)
        .then(({data}) => {
            commit('del'+capitalize(itemData.condition), data.data);
            commit('ajax', true);
        });
};
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



const createEmployee =({commit}, employee) =>{
    commit('ajax', false);
    axios.post('/employee', {name: employee.name, email: employee.email})
        .then(({data}) => {
            commit('addEmployee',data.data);
            commit('clearErrors');
            commit('ajax', true);
        })
        .catch(error => {
            //save errors
            commit('ajax',true);
            if (error.response.status === 422) {
                commit('addErrors', {data: error.response.data.errors});
            } else {
                commit('addErrors', {data: {error: ['Something went wrong. Please try again']}});
            }
        });
};

const delEmployee =({commit}, employee)=> {
    commit('ajax', false);
    axios.delete('/employee/' + employee.id)
        .then(({data}) => {
            commit('delEmployeeStore', data);
            commit('ajax', true);
        });
};

const changeGoal = ({commit,state }, goal)=> {
    commit('ajax',false);
    axios.put('/goal/'+state.goal.id, {goal_per_day: goal.goal_per_day, period: goal.period})
        .then(({data}) => {
            commit('updateGoalEdit',data);
            commit('clearErrors');
            commit('ajax',true);
        })
        .catch(error => {
            //save errors
            commit('ajax',true);
            if (error.response.status === 422) {
                commit('addErrors', {data: error.response.data.errors});
            } else {
                commit('addErrors', {data: {error: ['Something went wrong. Please try again']}});
            }
        });
};

const addGoal = ({commit}, goal) => {
    commit('ajax',false);
    axios.post('/goal', {goal_per_day: goal.goal_per_day, period: goal.period})
        .then(({data}) => {
            commit('flag', true);
            commit('updateGoalEdit',data);
            commit('calcProfitCircle');
            commit('clearErrors');
            commit('ajax', true);
        })
        .catch(error => {
            //save errors
            commit('ajax',true);
            if (error.response.status === 422) {
                commit('addErrors', {data: error.response.data.errors});
            } else {
                commit('addErrors', {data: {error: ['Something went wrong. Please try again']}});
            }
        });
};
function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
export {addGoal,changeGoal,delEmployee,createEmployee,loadData, createItem, deleteItem, editItem}