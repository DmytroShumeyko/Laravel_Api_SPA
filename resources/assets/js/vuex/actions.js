const loadData = ({commit}) => {
    axios.get('/api/user_data')
        .then(({data}) => {
            commit('setData', data);
        });
};
const createItem = ({commit}, itemData) => {
    commit('ajax', false);
    let data_sent = {};
    data_sent[itemData.condition] = itemData.data;
    data_sent['company_id'] = itemData.data.company_id;

    axios.post('/api/' + itemData.condition + 's/', data_sent)
        .then(({data}) => {
            commit('add' + capitalize(itemData.condition), data.data);
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
    commit('ajax', false);
    let data_sent = {};
    data_sent[itemData.condition] = itemData.data;
    data_sent['company_id'] = itemData.data.company_id;

    axios.patch('/api/' + itemData.condition + 's/' + itemData.data.id, data_sent)
        .then(({data}) => {
            commit('update' + capitalize(itemData.condition), data.data);
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
const deleteItem = ({commit}, itemData) => {
    commit('ajax', false);
    axios.delete('/api/' + itemData.condition + 's/' + itemData.data.id)
        .then(({data}) => {
            commit('del' + capitalize(itemData.condition), data.data);
            commit('ajax', true);
        });
};


function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

export {loadData, createItem, deleteItem, editItem}