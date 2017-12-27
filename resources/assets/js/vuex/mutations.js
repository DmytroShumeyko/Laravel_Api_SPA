const setData = (state, data) => {
    state.companies = data.companies;
    state.vendors = data.vendors;
    state.products = data.products;
    let user = {
        'id': data.id,
        'phone': data.phone,
        'chart': data.chart,
        'name': data.name,
        'email': data.email,
        'site': data.site,
        'address': data.address,
        'current_account': data.current_account,
        'bank': data.bank,
        'town': data.town,
        'mfo': data.mfo,
        'itn': data.itn
    };
    state.user = user;
};

/**
 * Order mutation
 *
 * @param state
 * @param data
 */
const addOrder = (state, data) => {
    let companyIndex = state.companies.findIndex((x) => x.id === data.company_id);
    state.companies[companyIndex].orders.unshift(data);
    $('#orderModal').modal('hide');
};
const updateOrder = (state, data) => {
    let companyIndex = state.companies.findIndex((x) => x.id === data.company_id);
    let index = state.companies[companyIndex].orders.findIndex((x) => x.id === data.id);
    state.companies[companyIndex].orders[index] = data;
    $('#orderModal').modal('hide');
};
const delOrder = (state, data) => {
    let companyIndex = state.companies.findIndex((x) => x.id === data.company_id);
    let index = state.companies[companyIndex].orders.findIndex((x) => x.id === data.id);
    state.companies[companyIndex].orders.splice(index, 1);
};

/**
 * Sale mutation
 *
 * @param state
 * @param data
 */
const addSale = (state, data) => {
    let companyIndex = state.companies.findIndex((x) => x.id === data.company_id);
    state.companies[companyIndex].sales.unshift(data);
    $('#saleModal').modal('hide');
};
const updateSale = (state, data) => {
    let companyIndex = state.companies.findIndex((x) => x.id === data.company_id);
    let index = state.companies[companyIndex].sales.findIndex((x) => x.id === data.id);
    state.companies[companyIndex].sales[index] = data;
    $('#saleModal').modal('hide');
};
const delSale = (state, data) => {
    let companyIndex = state.companies.findIndex((x) => x.id === data.company_id);
    let index = state.companies[companyIndex].sales.findIndex((x) => x.id === data.id);
    state.companies[companyIndex].sales.splice(index, 1);
};

/**
 * Payment mutation
 *
 * @param state
 * @param data
 */
const addPayment = (state, data) => {
    let companyIndex = state.companies.findIndex((x) => x.id === data.company_id);
    state.companies[companyIndex].payments.unshift(data);
    $('#pwModal').modal('hide');
};
const updatePayment = (state, data) => {
    let companyIndex = state.companies.findIndex((x) => x.id === data.company_id);
    let index = state.companies[companyIndex].payments.findIndex((x) => x.id === data.id);
    state.companies[companyIndex].payments[index] = data;
    $('#pwModal').modal('hide');
};
const delPayment = (state, data) => {
    let companyIndex = state.companies.findIndex((x) => x.id === data.company_id);
    let index = state.companies[companyIndex].payments.findIndex((x) => x.id === data.id);
    state.companies[companyIndex].payments.splice(index, 1);
};

/**
 * Withdraw mutation
 *
 * @param state
 * @param data
 */
const addWithdraw = (state, data) => {
    let companyIndex = state.companies.findIndex((x) => x.id === data.company_id);
    state.companies[companyIndex].withdraws.unshift(data);
    $('#pwModal').modal('hide');
};
const updateWithdraw = (state, data) => {
    let companyIndex = state.companies.findIndex((x) => x.id === data.company_id);
    let index = state.companies[companyIndex].withdraws.findIndex((x) => x.id === data.id);
    state.companies[companyIndex].withdraws[index] = data;
    $('#pwModal').modal('hide');
};
const delWithdraw = (state, data) => {
    let companyIndex = state.companies.findIndex((x) => x.id === data.company_id);
    let index = state.companies[companyIndex].withdraws.findIndex((x) => x.id === data.id);
    state.companies[companyIndex].withdraws.splice(index, 1);
};

/**
 * Product mutation
 *
 * @param state
 * @param data
 */
const addProduct = (state, data) => {
    state.products.unshift(data);
    $('#company-vendorModal').modal('hide');
};
const updateProduct = (state, data) => {
    let index = state.products.findIndex((x) => x.id === data.id);
    state.products[index] = data;
    $('#company-vendorModal').modal('hide');
};
const delProduct = (state, data) => {
    let index = state.products.findIndex((x) => x.id === data.id);
    state.products.splice(index, 1);
};

/**
 * Company mutation
 *
 * @param state
 * @param data
 */
const addCompany = (state, data) => {
    state.companies.unshift(data);
    $('#company-vendorModal').modal('hide');
};
const updateCompany = (state, data) => {
    let index = state.companies.findIndex((x) => x.id === data.id);
    state.companies[index] = data;
    $('#company-vendorModal').modal('hide');
};

/**
 * Vendor mutation
 *
 * @param state
 * @param data
 */
const addVendor = (state, data) => {
    state.vendors.unshift(data);
    $('#company-vendorModal').modal('hide');
};
const updateVendor = (state, data) => {
    let index = state.vendors.findIndex((x) => x.id === data.id);
    state.vendors[index] = data;
    $('#company-vendorModal').modal('hide');
};
/**
 * User mutation
 *
 * @param state
 * @param data
 */
const updateUser = (state, data) => {
    let user = {
        'phone': data.phone,
        'name': data.name,
        'email': data.email,
        'site': data.site,
        'address': data.address,
        'current_account': data.current_account,
        'bank': data.bank,
        'town': data.town,
        'mfo': data.mfo,
        'itn': data.itn
    };
    state.user = user;
    $('#company-vendorModal').modal('hide');
};

const ajax = (state, data) => {
    state.ajax = data;
};
const addErrors = (state, {data}) => {
    state.errors = data;
};
const clearErrors = (state) => {
    state.errors = '';
};
export {
    setData,
    ajax,
    addOrder,
    updateOrder,
    delOrder,
    addErrors,
    clearErrors,
    addSale,
    delSale,
    updateSale,
    addCompany,
    addPayment,
    addWithdraw,
    delPayment,
    delWithdraw,
    updateCompany,
    updatePayment,
    updateWithdraw,
    addVendor,
    updateVendor,
    addProduct,
    updateProduct,
    delProduct,
    updateUser
}