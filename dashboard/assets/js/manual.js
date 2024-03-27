window.addEventListener('load', (event) => {
    const queryString = new URLSearchParams(window.location.search)
    let msg = queryString.get('msg')
    let err = queryString.get('err')
    if(msg){
        Snackbar.show({
            text: msg,
            pos: 'bottom-right',
            actionText: 'Success',
            actionTextColor: '#8dbf42',
            duration: 5000
        });
    }
    if(err){
        Snackbar.show({
            text: err,
            pos: 'bottom-right',
            actionText: 'Error',
            actionTextColor: '#FF5E74',
            duration: 5000
        });
    }
    let login = localStorage.getItem('login_id')
    if(login == null){
        let thisURl = window.location.href
        if(thisURl.charAt(thisURl.length-1) != '/'){
            location.replace('./')
        }
    } else{
        $.ajax({
            type: "POST",
            url: "ajax/sessionSet.php",
            data:{'login':login},
            success: function(data){
                if(window.location.href.charAt(window.location.href.length-1) == '/'){
                    location.replace('dashboard.php')
                } else{
                    if(data == 'false'){
                        location.reload()
                    }
                }
            }
        });
        setInterval(function(){
            $.ajax({
                type: "POST",
                url: "ajax/checkOrder.php",
                data: { 'login': login },
                success: function(data){
                    if(data != 'false' && data!= ''){
                        document.getElementById('notificationContent').innerHTML = data
                        document.getElementById("audio").play()
                        document.getElementById('notificationLink').click()
                    }
                }
            });
        }, 5000)
    }
    $('.convert-data-table').DataTable({
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
           "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7 
    });
});
function loginCheck(e){
    e.preventDefault()
    let user = document.getElementById('username')
    let pass = document.getElementById('password')

    if(user.value == ''){
        user.style.border = '1px solid red'
    } else{
        user.style.border = '1px solid #bfc9d4'
        if(pass.value == ''){
            pass.style.border = '1px solid red'
        } else{
            pass.style.border = '1px solid #bfc9d4'
            $.ajax({
                type: "POST",
                url: "ajax/loginCheck.php",
                data:{'username':user.value,'password': pass.value},
                success: function(data){
                    if(data == 'Invalid Username!'){
                        document.getElementById('Message').innerHTML = data
                        user.style.border = '1px solid red'
                        pass.style.border = '1px solid #bfc9d4'
                    } else{
                        if(data == 'Incorrect Password!'){
                            document.getElementById('Message').innerHTML = data
                            user.style.border = '1px solid #bfc9d4'
                            pass.style.border = '1px solid red'
                        } else{
                            localStorage.setItem('login_id', data)
                            $.ajax({
                                type: "POST",
                                url: "ajax/sessionSet.php",
                                data:{'login':data},
                                success: function(data){
                                    location.replace('dashboard.php')
                                }
                            });
                        }
                    }
                }
            });
        }
    }
}
function ChangePassword(e){
    e.preventDefault()

    let password = document.getElementById('password')
    let newPassword = document.getElementById('newPassword')
    let retypeNewPassword = document.getElementById('retypeNewPassword')

    if(password.value == ''){
        password.style.border = '1px solid red'
    } else{
        password.style.border = '1px solid #bfc9d4'
        if(newPassword.value == ''){
            newPassword.style.border = '1px solid red'
        } else{
            newPassword.style.border = '1px solid #bfc9d4'
            if(retypeNewPassword.value == ''){
                retypeNewPassword.style.border = '1px solid red'
            } else{
                retypeNewPassword.style.border = '1px solid #bfc9d4'
                if(newPassword.value == retypeNewPassword.value){
                    $.ajax({
                        type: "POST",
                        url: "ajax/changePassword.php",
                        data:{'password':password.value,'newPassword': newPassword.value},
                        success: function(data){
                            if(data == 'Incorrect Old Password!'){
                                document.getElementById('Message').innerHTML = data
                                password.style.border = '1px solid red'
                            } else{
                                location.replace('dashboard.php?msg=Password Changed!')
                            }
                        }
                    });
                } else{
                    document.getElementById('Message').innerHTML = 'Password Mismatch!'
                    newPassword.style.border = '1px solid red'
                    retypeNewPassword.style.border = '1px solid red'
                }
            }
        }
    }
}
function logOut(){
    $.ajax({
        type: "POST",
        url: "ajax/logoutCheck.php",
        data:{'username':1,},
        success: function(data){
            if(data == 'success'){
                localStorage.removeItem('login_id')
                location.replace('./')
            }
        }
    });
}
function branchAdd(){
    let name = document.getElementById('name')
    let image = document.getElementById('image')
    let username = document.getElementById('username')
    let phone = document.getElementById('phone')
    let password = document.getElementById('password')
    let retype_password = document.getElementById('retype_password')
    let latitude = document.getElementById('latitude')
    let longitude = document.getElementById('longitude')
    let address = document.getElementById('address')

    if(name.value == ''){
        name.style.border = '1px solid red'
        return false
    } else{
        name.style.border = '1px solid #bfc9d4'
        if(image.value == ''){
            image.style.border = '1px solid red'
            return false
        } else{
            image.style.border = '1px solid #bfc9d4'
            if(username.value == ''){
                username.style.border = '1px solid red'
                return false
            } else{
                username.style.border = '1px solid #bfc9d4'
                if(document.getElementById('usernameCheck').innerHTML == 'Username Exists!'){
                    username.style.border = '1px solid red'
                    return false
                } else{
                    username.style.border = '1px solid #bfc9d4'
                    if(phone.value == ''){
                        phone.style.border = '1px solid red'
                        return false
                    } else{
                        phone.style.border = '1px solid #bfc9d4'
                        if(password.value == ''){
                            password.style.border = '1px solid red'
                            return false
                        } else{
                            password.style.border = '1px solid #bfc9d4'
                            if(retype_password.value == ''){
                                retype_password.style.border = '1px solid red'
                                return false
                            } else{
                                retype_password.style.border = '1px solid #bfc9d4'
                                if(password.value != retype_password.value){
                                    document.getElementById('passWordCheck').innerHTML = 'Password Mismatch!'
                                    document.getElementById('passWordCheck').style.color = 'red'
                                    password.style.border = '1px solid red'
                                    retype_password.style.border = '1px solid red'
                                    return false
                                } else{
                                    document.getElementById('passWordCheck').innerHTML = ''
                                    password.style.border = '1px solid #bfc9d4'
                                    retype_password.style.border = '1px solid #bfc9d4'
                                    if(latitude.value == ''){
                                        latitude.style.border = '1px solid red'
                                        return false
                                    } else{
                                        latitude.style.border = '1px solid #bfc9d4'
                                        if(longitude.value == ''){
                                            longitude.style.border = '1px solid red'
                                            return false
                                        } else{
                                            longitude.style.border = '1px solid #bfc9d4'
                                            if(address.value == ''){
                                                address.style.border = '1px solid red'
                                                return false
                                            } else{
                                                address.style.border = '1px solid #bfc9d4'
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
// function branchEdit(login_id){
//     let name = document.getElementById('name' + login_id)
//     let image = document.getElementById('image' + login_id)
//     let phone = document.getElementById('phone' + login_id)
//     let latitude = document.getElementById('latitude' + login_id)
//     let longitude = document.getElementById('longitude' + login_id)
//     let address = document.getElementById('address' + login_id)

//     if(name.value == ''){
//         name.style.border = '1px solid red'
//         return false
//     } else{
//         name.style.border = '1px solid #bfc9d4'
//         if(image.value == ''){
//             image.style.border = '1px solid red'
//             return true
//         } else{
//             image.style.border = '1px solid #bfc9d4'
//             if(phone.value == ''){
//                 phone.style.border = '1px solid red'
//                 return false
//             } else{
//                 phone.style.border = '1px solid #bfc9d4'
//                 if(latitude.value == ''){
//                     latitude.style.border = '1px solid red'
//                     return false
//                 } else{
//                     latitude.style.border = '1px solid #bfc9d4'
//                     if(longitude.value == ''){
//                         longitude.style.border = '1px solid red'
//                         return false
//                     } else{
//                         longitude.style.border = '1px solid #bfc9d4'
//                         if(address.value == ''){
//                             address.style.border = '1px solid red'
//                             return false
//                         } else{
//                             address.style.border = '1px solid #bfc9d4'
//                         }
//                     }
//                 }
//             }
//         }
//     }
// }

function cashbackStatus(id){
    $.ajax({
        type: "POST",
        url: "ajax/cashbackStatus.php",
        data:{'offer_id':id},
        success: function(data){
            if(data == 'true'){
                Snackbar.show({
                    text: 'Cashback status updated',
                    pos: 'bottom-right',
                    actionText: 'Success',
                    actionTextColor: '#A1D433',
                    duration: 5000
                });
                return true
            } else{
                Snackbar.show({
                    text: 'Status updation failed',
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
                if(document.getElementById('C' + id).checked){
                    document.getElementById('C' + id).checked = false
                } else{
                    document.getElementById('C' + id).checked = true
                }
            }
        }
    });
}

// function firstOrderStatus(id){
//     $.ajax({
//         type: "POST",
//         url: "ajax/firstOrderStatus.php",
//         data:{'offer_id':id},
//         success: function(data){
//             if(data == 'true'){
//                 Snackbar.show({
//                     text: 'First Order status updated',
//                     pos: 'bottom-right',
//                     actionText: 'Success',
//                     actionTextColor: '#A1D433',
//                     duration: 5000
//                 });
//                 return true
//             } else{
//                 Snackbar.show({
//                     text: 'Status updation failed',
//                     pos: 'bottom-right',
//                     actionText: 'Error',
//                     actionTextColor: '#8dbf42',
//                     duration: 5000
//                 });
//                 if(document.getElementById('F' + id).checked){
//                     document.getElementById('F' + id).checked = false
//                 } else{
//                     document.getElementById('F' + id).checked = true
//                 }
//             }
//         }
//     });
// }
function branchChangePassword(login_id){
    let password = document.getElementById('password' + login_id)
    let retypePassword = document.getElementById('retypePassword' + login_id)

    if(password.value == ''){
        password.style.border = '1px solid red'
        return false
    } else{
        password.style.border = '1px solid #bfc9d4'
        if(retypePassword.value == ''){
            retypePassword.style.border = '1px solid red'
            return false
        } else{
            retypePassword.style.border = '1px solid #bfc9d4'
            if(password.value != retypePassword.value){
                password.style.border = '1px solid red'
                retypePassword.style.border = '1px solid red'
                return false
            } else{
                password.style.border = '1px solid #bfc9d4'
                retypePassword.style.border = '1px solid #bfc9d4'
            }
        }
    }
}
function userNameCheck(value){
    $.ajax({
        type: "POST",
        url: "ajax/usernameCheck.php",
        data:{'username':value},
        success: function(data){
            if(data == 'true'){
                document.getElementById('usernameCheck').innerHTML = 'Username Exists!'
                document.getElementById('usernameCheck').style.color = 'red'
            } else{
                document.getElementById('usernameCheck').innerHTML = ''
            }
        }
    });
}
function checkCategory(value){
    $.ajax({
        type: "POST",
        url: "ajax/categoryCheck.php",
        data:{'category':value,'category_id':0},
        success: function(data){
            if(data == 'true'){
                document.getElementById('categoryError').innerHTML = 'Category Exists!'
                document.getElementById('categoryError').style.color = 'red'
            }
        }
    });
}
function checkCategoryEdit(value,id,count){
    $.ajax({
        type: "POST",
        url: "ajax/categoryCheck.php",
        data:{'category':value,'category_id':id},
        success: function(data){
            if(data == 'true'){
                document.getElementById('categoryEditError' + count).innerHTML = 'Category Exists!'
                document.getElementById('categoryEditError' + count).style.color = 'red'
            }
        }
    });
}
function categoryAdd(){
    let name = document.getElementById('name')
    let image = document.getElementById('image')

    if(name.value == ''){
        name.style.border = '1px solid red'
        return false
    } else{
        name.style.border = '1px solid #bfc9d4'
        if(document.getElementById('categoryError').innerHTML != 'Category Exists!'){
            if(image.value == ''){
                image.style.border = '1px solid red'
                return false
            } else{
                image.style.border = '1px solid #bfc9d4'
            }
        } else{
            name.style.border = '1px solid red'
            return false
        }
    }
}
function categoryEdit(id){
    let name = document.getElementById('name' + id)
    let image = document.getElementById('image' + id)

    if(name.value == ''){
        name.style.border = '1px solid red'
        return false
    } else{
        name.style.border = '1px solid #bfc9d4'
        if(document.getElementById('categoryEditError' + id).innerHTML != 'Category Exists!'){
            if(image.value == ''){
                image.style.border = '1px solid red'
                return false
            } else{
                image.style.border = '1px solid #bfc9d4'
            }
        } else{
            name.style.border = '1px solid red'
            return false
        }
    }
}
function  productAdd(){
    let name = document.getElementById('name')
    let image = document.getElementById('image')
    let category = document.getElementById('category')
    let type = document.getElementById('type')

    if(name.value == ''){
        name.style.border = '1px solid red'
        return false
    } else{
        name.style.border = '1px solid #bfc9d4'
        if(image.value == ''){
            image.style.border = '1px solid red'
            return false
        } else{
            image.style.border = '1px solid #bfc9d4'
            if(category.value == 'Select Category'){
                category.style.border = '1px solid red'
                return false
            } else{
                category.style.border = '1px solid #bfc9d4'
                if(type.value == 'Select Type'){
                    type.style.border = '1px solid red'
                    return false
                } else{
                    type.style.border = '1px solid #bfc9d4'
                }
            }
        }
    }
}
function productRecommended(login_id,id){
    $.ajax({
        type: "POST",
        url: "ajax/productRecommend.php",
        data:{'login_id':login_id,'product_id':id,},
        success: function(data){
            if(data == 'true'){
                Snackbar.show({
                    text: 'Recommend status updated',
                    pos: 'bottom-right',
                    actionText: 'Success',
                    actionTextColor: '#A1D433',
                    duration: 5000
                });
                return true
            } else{
                Snackbar.show({
                    text: 'Recommend updation failed',
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
                if(document.getElementById('R' + id).checked){
                    document.getElementById('R' + id).checked = false
                } else{
                    document.getElementById('R' + id).checked = true
                }
            }
        }
    });
}
function productCartRecommended(login_id,id){
    $.ajax({
        type: "POST",
        url: "ajax/productCartRecommended.php",
        data:{'login_id':login_id,'product_id':id,},
        success: function(data){
            if(data == 'true'){
                Snackbar.show({
                    text: 'Recommend status updated',
                    pos: 'bottom-right',
                    actionText: 'Success',
                    actionTextColor: '#A1D433',
                    duration: 5000
                });
                return true
            } else{
                Snackbar.show({
                    text: 'Recommend updation failed',
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
                if(document.getElementById('CR' + id).checked){
                    document.getElementById('CR' + id).checked = false
                } else{
                    document.getElementById('CR' + id).checked = true
                }
            }
        }
    });
}
function productOffer(id,type){
    if(type == 1){
        let percentage = document.getElementById('per'+id).value

        if(!parseInt(percentage)){
            Snackbar.show({
                text: 'Invalid Percentage',
                pos: 'bottom-right',
                actionText: 'Error',
                actionTextColor: '#8dbf42',
                duration: 5000
            });
        } else{
            $.ajax({
                type: "POST",
                url: "ajax/productOffer.php",
                data:{'product_id':id,'percentage': percentage},
                success: function(data){
                    if(data == 'true'){
                        Snackbar.show({
                            text: 'Offer status updated',
                            pos: 'bottom-right',
                            actionText: 'Success',
                            actionTextColor: '#A1D433',
                            duration: 5000
                        });
                        document.getElementById('closeModal' + id).click()
                        $.ajax({
                            type: "POST",
                            url: "ajax/productOfferCheck.php",
                            data:{'product_id':id},
                            success: function(data){
                                document.getElementById('offercheck' + id).innerHTML = data
                                return true
                            }
                        });
                    } else{
                        Snackbar.show({
                            text: 'Offer updation failed',
                            pos: 'bottom-right',
                            actionText: 'Error',
                            actionTextColor: '#8dbf42',
                            duration: 5000
                        });
                        if(document.getElementById('O' + id).checked){
                            document.getElementById('O' + id).checked = false
                        } else{
                            document.getElementById('O' + id).checked = true
                        }
                    }
                }
            });
        }
    } else{
        $.ajax({
            type: "POST",
            url: "ajax/productOffer.php",
            data:{'product_id':id},
            success: function(data){
                if(data == 'true'){
                    Snackbar.show({
                        text: 'Offer status updated',
                        pos: 'bottom-right',
                        actionText: 'Success',
                        actionTextColor: '#A1D433',
                        duration: 5000
                    });
                    $.ajax({
                        type: "POST",
                        url: "ajax/productOfferCheck.php",
                        data:{'product_id':id},
                        success: function(data){
                            document.getElementById('offercheck' + id).innerHTML = data
                            return true
                        }
                    });
                } else{
                    Snackbar.show({
                        text: 'Offer updation failed',
                        pos: 'bottom-right',
                        actionText: 'Error',
                        actionTextColor: '#8dbf42',
                        duration: 5000
                    });
                    if(document.getElementById('O' + id).checked){
                        document.getElementById('O' + id).checked = false
                    } else{
                        document.getElementById('O' + id).checked = true
                    }
                }
            }
        });
    }
}
function productStatus(login_id,id){
    $.ajax({
        type: "POST",
        url: "ajax/productStatus.php",
        data:{'login_id':login_id,'product_id':id},
        success: function(data){
            if(data == 'true'){
                Snackbar.show({
                    text: 'Product status updated',
                    pos: 'bottom-right',
                    actionText: 'Success',
                    actionTextColor: '#A1D433',
                    duration: 5000
                });
                return true
            } else{
                Snackbar.show({
                    text: 'Status updation failed',
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
                if(document.getElementById('S' + id).checked){
                    document.getElementById('S' + id).checked = false
                } else{
                    document.getElementById('S' + id).checked = true
                }
            }
        }
    });
}
function productOverallStatus(id){
    $.ajax({
        type: "POST",
        url: "ajax/productOverallStatus.php",
        data:{'product_id':id},
        success: function(data){
            if(data == 'true'){
                Snackbar.show({
                    text: 'Product status updated',
                    pos: 'bottom-right',
                    actionText: 'Success',
                    actionTextColor: '#A1D433',
                    duration: 5000
                });
                return true
            } else{
                Snackbar.show({
                    text: 'Status updation failed',
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
                if(document.getElementById('S' + id).checked){
                    document.getElementById('S' + id).checked = false
                } else{
                    document.getElementById('S' + id).checked = true
                }
            }
        }
    });
}
function categoryStatus(login_id,id){
    $.ajax({
        type: "POST",
        url: "ajax/categoryStatus.php",
        data:{'login_id':login_id,'category_id':id},
        success: function(data){
            if(data == 'true'){
                Snackbar.show({
                    text: 'Category status updated',
                    pos: 'bottom-right',
                    actionText: 'Success',
                    actionTextColor: '#A1D433',
                    duration: 5000
                });
                return true
            } else{
                Snackbar.show({
                    text: 'Status updation failed',
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
                if(document.getElementById('S' + id).checked){
                    document.getElementById('S' + id).checked = false
                } else{
                    document.getElementById('S' + id).checked = true
                }
            }
        }
    });
}

function membershipStatus(id){
    $.ajax({
        type: "POST",
        url: "ajax/membershipStatus.php",
        data:{'membership_id':id},
        success: function(data){
            if(data == 'true'){
                Snackbar.show({
                    text: 'Membership status updated',
                    pos: 'bottom-right',
                    actionText: 'Success',
                    actionTextColor: '#A1D433',
                    duration: 5000
                });
                return true
            } else{
                Snackbar.show({
                    text: 'Status updation failed',
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
                if(document.getElementById('S' + id).checked){
                    document.getElementById('S' + id).checked = false
                } else{
                    document.getElementById('S' + id).checked = true
                }
            }
        }
    });
}

function categoryOverallStatus(id){
    $.ajax({
        type: "POST",
        url: "ajax/categoryOverallStatus.php",
        data:{'category_id':id},
        success: function(data){
            if(data == 'true'){
                Snackbar.show({
                    text: 'Category status updated',
                    pos: 'bottom-right',
                    actionText: 'Success',
                    actionTextColor: '#A1D433',
                    duration: 5000
                });
                return true
            } else{
                Snackbar.show({
                    text: 'Status updation failed',
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
                if(document.getElementById('S' + id).checked){
                    document.getElementById('S' + id).checked = false
                } else{
                    document.getElementById('S' + id).checked = true
                }
            }
        }
    });
}
function selfPickupStatus(id){
    $.ajax({
        type: "POST",
        url: "ajax/selfPickupStatus.php",
        data:{'id':id},
        success: function(data){
            if(data == 'true'){
                Snackbar.show({
                    text: 'Self pickup status updated',
                    pos: 'bottom-right',
                    actionText: 'Success',
                    actionTextColor: '#A1D433',
                    duration: 5000
                });
                return true
            } else{
                Snackbar.show({
                    text: 'Status updation failed',
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
                if(document.getElementById('S' + id).checked){
                    document.getElementById('S' + id).checked = false
                } else{
                    document.getElementById('S' + id).checked = true
                }
            }
        }
    });
}
function branchStatus(id){
    $.ajax({
        type: "POST",
        url: "ajax/branchStatus.php",
        data:{'login_id':id},
        success: function(data){
            if(data == 'true'){
                Snackbar.show({
                    text: 'Branch status updated',
                    pos: 'bottom-right',
                    actionText: 'Success',
                    actionTextColor: '#A1D433',
                    duration: 5000
                });
                return true
            } else{
                Snackbar.show({
                    text: 'Status updation failed',
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
                if(document.getElementById('S' + id).checked){
                    document.getElementById('S' + id).checked = false
                } else{
                    document.getElementById('S' + id).checked = true
                }
            }
        }
    });
}
function deliveryPartnerStatus(id){
    $.ajax({
        type: "POST",
        url: "ajax/deliveryPartnerStatus.php",
        data:{'delivery_partner_id':id},
        success: function(data){
            if(data == 'true'){
                Snackbar.show({
                    text: 'Delivery Partner status updated',
                    pos: 'bottom-right',
                    actionText: 'Success',
                    actionTextColor: '#A1D433',
                    duration: 5000
                });
                return true
            } else{
                Snackbar.show({
                    text: 'Status updation failed',
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
                if(document.getElementById('S' + id).checked){
                    document.getElementById('S' + id).checked = false
                } else{
                    document.getElementById('S' + id).checked = true
                }
            }
        }
    });
}
function deliveryPartnerOnlineStatus(id){
    $.ajax({
        type: "POST",
        url: "ajax/deliveryPartnerOnlineStatus.php",
        data:{'delivery_partner_id':id},
        success: function(data){
            if(data == 'true'){
                Snackbar.show({
                    text: 'Delivery Partner status updated',
                    pos: 'bottom-right',
                    actionText: 'Success',
                    actionTextColor: '#A1D433',
                    duration: 5000
                });
                return true
            } else{
                Snackbar.show({
                    text: 'Status updation failed',
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
                if(document.getElementById('S' + id).checked){
                    document.getElementById('S' + id).checked = false
                } else{
                    document.getElementById('S' + id).checked = true
                }
            }
        }
    });
}
function introBannerStatus(id){
    $.ajax({
        type: "POST",
        url: "ajax/introBannerStatus.php",
        data:{'intro_banner_id':id},
        success: function(data){
            if(data == 'true'){
                Snackbar.show({
                    text: 'Banner status updated',
                    pos: 'bottom-right',
                    actionText: 'Success',
                    actionTextColor: '#A1D433',
                    duration: 5000
                });
                return true
            } else{
                Snackbar.show({
                    text: 'Status updation failed',
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
                if(document.getElementById('S' + id).checked){
                    document.getElementById('S' + id).checked = false
                } else{
                    document.getElementById('S' + id).checked = true
                }
            }
        }
    });
}
function paymentStatus(id){
    $.ajax({
        type: "POST",
        url: "ajax/paymentStatus.php",
        data:{'payment_method_id':id},
        success: function(data){
            if(data == 'true'){
                Snackbar.show({
                    text: 'Payment mode status updated',
                    pos: 'bottom-right',
                    actionText: 'Success',
                    actionTextColor: '#A1D433',
                    duration: 5000
                });
                return true
            } else{
                Snackbar.show({
                    text: 'Status updation failed',
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
                if(document.getElementById('S' + id).checked){
                    document.getElementById('S' + id).checked = false
                } else{
                    document.getElementById('S' + id).checked = true
                }
            }
        }
    });
}
function servicetypeStatus(id){
    $.ajax({
        type: "POST",
        url: "ajax/servicetypeStatus.php",
        data:{'service_type_id':id},
        success: function(data){
            if(data == 'true'){
                Snackbar.show({
                    text: 'Service Type status updated',
                    pos: 'bottom-right',
                    actionText: 'Success',
                    actionTextColor: '#A1D433',
                    duration: 5000
                });
                return true
            } else{
                Snackbar.show({
                    text: 'Status updation failed',
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
                if(document.getElementById('S' + id).checked){
                    document.getElementById('S' + id).checked = false
                } else{
                    document.getElementById('S' + id).checked = true
                }
            }
        }
    });
}

function userStatus(id){
    $.ajax({
        type: "POST",
        url: "ajax/userStatus.php",
        data:{'user_id':id},
        success: function(data){
            if(data == 'true'){
                Snackbar.show({
                    text: 'User status updated',
                    pos: 'bottom-right',
                    actionText: 'Success',
                    actionTextColor: '#A1D433',
                    duration: 5000
                });
                return true
            } else{
                Snackbar.show({
                    text: 'Status updation failed',
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
                if(document.getElementById('S' + id).checked){
                    document.getElementById('S' + id).checked = false
                } else{
                    document.getElementById('S' + id).checked = true
                }
            }
        }
    });
}

function updateControl(){
    let m = document.getElementById('minimum_order')
    let o = document.getElementById('order_distance')
    let b = document.getElementById('best_selling_count')
    let c = document.getElementById('cart_count')
    let i = document.getElementById('app_intime')
    let t = document.getElementById('app_outtime')

    if(m.value == ''){
        m.style.border = '1px solid red'
        return false
    } else{
        m.style.border = '1px solid #bfc9d4'
        if(o.value == ''){
            o.style.border = '1px solid red'
            return false
        } else{
            o.style.border = '1px solid #bfc9d4'
            if(b.value == ''){
                b.style.border = '1px solid red'
                return false
            } else{
                b.style.border = '1px solid #bfc9d4'
                if(c.value == ''){
                    c.style.border = '1px solid red'
                    return false
                } else{
                    c.style.border = '1px solid #bfc9d4'
                    if(i.value == ''){
                        i.style.border = '1px solid red'
                        return false
                    } else{
                        i.style.border = '1px solid #bfc9d4'
                        if(t.value == ''){
                            t.style.border = '1px solid red'
                            return false
                        } else{
                            t.style.border = '1px solid #bfc9d4'
                        }
                    }
                }
            }
        }
    }
}
function couponCheck(id,count){
    if(count != ''){
        var offer_coupon = document.getElementById('offer_coupon' + count)
        var couponError = document.getElementById('couponError' + count)
    } else{
        var offer_coupon = document.getElementById('offer_coupon')
        var couponError = document.getElementById('couponError')
    }

    $.ajax({
        type: "POST",
        url: "ajax/couponError.php",
        data:{'coupon':offer_coupon.value,'id': id},
        success: function(data){
            if(data == 'true'){
                couponError.innerHTML = 'Coupon code already exists!'
                couponError.style.color = '#FF0000'
                offer_coupon.style.border = '1px solid red'
            } else{
                couponError.innerHTML = ''
                offer_coupon.style.border = '1px solid #bfc9d4'
            }
        }
    });
}
function offerAdd(){
    let m = document.getElementById('offer_coupon')
    let o = document.getElementById('offer_percentage')
    let b = document.getElementById('minimum_ordering_amount')
    let c = document.getElementById('maximum_discount_amount')
    let couponError = document.getElementById('couponError')

    if(m.value == ''){
        m.style.border = '1px solid red'
        return false
    } else{
        m.style.border = '1px solid #bfc9d4'
        if(o.value == ''){
            o.style.border = '1px solid red'
            return false
        } else{
            o.style.border = '1px solid #bfc9d4'
            if(b.value == ''){
                b.style.border = '1px solid red'
                return false
            } else{
                b.style.border = '1px solid #bfc9d4'
                if(c.value == ''){
                    c.style.border = '1px solid red'
                    return false
                } else{
                    c.style.border = '1px solid #bfc9d4'
                    if(couponError.innerHTML == 'Coupon code already exists!'){
                        m.style.border = '1px solid red'
                        return false
                    } else{
                        return true
                    }
                }
            }
        }
    }
}
function offerEdit(id){
    let m = document.getElementById('offer_coupon' + id)
    let o = document.getElementById('offer_percentage' + id)
    let b = document.getElementById('minimum_ordering_amount' + id)
    let c = document.getElementById('maximum_discount_amount' + id)
    let couponError = document.getElementById('couponError' + id)

    if(m.value == ''){
        m.style.border = '1px solid red'
        return false
    } else{
        m.style.border = '1px solid #bfc9d4'
        if(o.value == ''){
            o.style.border = '1px solid red'
            return false
        } else{
            o.style.border = '1px solid #bfc9d4'
            if(b.value == ''){
                b.style.border = '1px solid red'
                return false
            } else{
                b.style.border = '1px solid #bfc9d4'
                if(c.value == ''){
                    c.style.border = '1px solid red'
                    return false
                } else{
                    c.style.border = '1px solid #bfc9d4'
                    if(couponError.innerHTML == 'Coupon code already exists!'){
                        m.style.border = '1px solid red'
                        return false
                    } else{
                        return true
                    }
                }
            }
        }
    }
}
function offerInApp(id){
    $.ajax({
        type: "POST",
        url: "ajax/offerInApp.php",
        data:{'offer_id':id},
        success: function(data){
            if(data == 'true'){
                Snackbar.show({
                    text: 'Offer In App status updated',
                    pos: 'bottom-right',
                    actionText: 'Success',
                    actionTextColor: '#A1D433',
                    duration: 5000
                });
                return true
            } else{
                Snackbar.show({
                    text: 'In App status updation failed',
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
                if(document.getElementById('I' + id).checked){
                    document.getElementById('I' + id).checked = false
                } else{
                    document.getElementById('I' + id).checked = true
                }
            }
        }
    });
}
function offerStatus(id){
    $.ajax({
        type: "POST",
        url: "ajax/offerStatus.php",
        data:{'offer_id':id},
        success: function(data){
            if(data == 'true'){
                Snackbar.show({
                    text: 'Offer status updated',
                    pos: 'bottom-right',
                    actionText: 'Success',
                    actionTextColor: '#A1D433',
                    duration: 5000
                });
                return true
            } else{
                Snackbar.show({
                    text: 'Status updation failed',
                    pos: 'bottom-right',
                    actionText: 'Error',
                    actionTextColor: '#8dbf42',
                    duration: 5000
                });
                if(document.getElementById('S' + id).checked){
                    document.getElementById('S' + id).checked = false
                } else{
                    document.getElementById('S' + id).checked = true
                }
            }
        }
    });
}
function bannerAdd(){
    let banner = document.getElementById('banner')
    let position = document.getElementById('position')
    let category = document.getElementById('category')

    if(banner.value == ''){
        banner.style.border = '1px solid red'
        return false
    } else{
        banner.style.border = '1px solid #bfc9d4'
        if(position.value == 'Select Position'){
            position.style.border = '1px solid red'
            return false
        } else{
            position.style.border = '1px solid #bfc9d4'
            if(category.value == 'Select Category'){
                category.style.border = '1px solid red'
                return false
            } else{
                category.style.border = '1px solid #bfc9d4'
            }
        }
    }
}
function bannerEdit(id){
    let banner = document.getElementById('banner' + id)
    if(banner.value == ''){
        banner.style.border = '1px solid red'
        return false
    } else{
        banner.style.border = '1px solid #bfc9d4'
    }
}
function checkUnit(value,id){
    let unitError
    if(id == 0){
        unitError = document.getElementById('unitError')
    } else{
        unitError = document.getElementById('unitError' + id)
    }
    $.ajax({
        type: "POST",
        url: "ajax/unitCheck.php",
        data:{'unit':value,'unit_id':id},
        success: function(data){
            if(data == 'true'){
                unitError.innerHTML = 'Unit Exists!'
                unitError.style.color = 'red'
            } else{
                unitError.innerHTML = ''
            }
        }
    });
}
function unitAdd(){
    let name = document.getElementById('name')
    let unitError = document.getElementById('unitError')

    if(name.value == ''){
        name.style.border = '1px solid red'
        return false
    } else{
        name.style.border = '1px solid #bfc9d4'
        if(unitError.innerHTML == 'Unit Exists!'){
            name.style.border = '1px solid red'
            return false
        } else{
            name.style.border = '1px solid #bfc9d4'
        }
    }
}
function unitEdit(id){
    let name = document.getElementById('name' + id)
    let unitError = document.getElementById('unitError' + id)

    if(name.value == ''){
        name.style.border = '1px solid red'
        return false
    } else{
        name.style.border = '1px solid #bfc9d4'
        if(unitError.innerHTML == 'Unit Exists!'){
            name.style.border = '1px solid red'
            return false
        } else{
            name.style.border = '1px solid #bfc9d4'
        }
    }
}
function changeNotificationType(val){
    let TypeClass = document.getElementById('typeClass')

    if(val == 3){
        TypeClass.classList.add('col-sm-12')
        TypeClass.classList.remove('col-sm-6')
        document.getElementById('categoryClass').classList.add('hide')
        document.getElementById('urlClass').classList.add('hide')
    } else{
        TypeClass.classList.add('col-sm-6')
        TypeClass.classList.remove('col-sm-12')
        if(val == 2){
            document.getElementById('categoryClass').classList.remove('hide')
            document.getElementById('urlClass').classList.add('hide')
        } else{
            document.getElementById('categoryClass').classList.add('hide')
            document.getElementById('urlClass').classList.remove('hide')
        }
    }
}
function notificationAdd(){
    let title = document.getElementById('title')
    // let image = document.getElementById('image')
    let type = document.getElementById('type')
    let url = document.getElementById('url')
    let category = document.getElementById('category')
    let body = document.getElementById('body')

    if(title.value == ''){
        title.style.border = '1px solid red'
        return false
    } else{
        title.style.border = '1px solid #bfc9d4'
        // if(image.value == ''){
        //     image.style.border = '1px solid red'
        //     return false
        // } else{
        //     image.style.border = '1px solid #bfc9d4'
            if(type.value == 'Select Type'){
                type.style.border = '1px solid red'
                return false
            } else{
                type.style.border = '1px solid #bfc9d4'
                if(type.value == 1){
                    if(url.value == ''){
                        url.style.border = '1px solid red'
                        return false
                    } else{
                        url.style.border = '1px solid #bfc9d4'
                    }
                } else{
                    if(type.value == 2){
                        if(category.value == 'Select Category'){
                            category.style.border = '1px solid red'
                            return false
                        } else{
                            category.style.border = '1px solid #bfc9d4'
                        }
                    }
                }
                if(body.value == ''){
                    body.style.border = '1px solid red'
                    return false
                } else{
                    body.style.border = '1px solid #bfc9d4'
                }
            }
        }
    }
// }
function filterReport(url){
    let fd = document.getElementById('fd')
    let ld = document.getElementById('ld')
    let city = document.getElementById('cityvalue')
    let bg = document.getElementById('bg')

    if(fd.value == ''){
        fd.style.border = '1px solid red'
        return false
    } else{
        fd.style.border = '1px solid #bfc9d4'
        if(ld.value == ''){
            ld.style.border = '1px solid red'
            return false
        } else{
            ld.style.border = '1px solid #bfc9d4'
            // if(city.value == ''){
            //     city.style.border = '1px solid red'
            //     return false
            // }else{
            //     city.style.border = '1px solid #bfc9d4'
                location.replace(url+'?fd='+fd.value+'&ld='+ld.value+'&city='+city.value+'&bg='+bg.value)
            // }
        }
    }
}
function deliveryfilterReport(url,id){
    let fd = document.getElementById('fd')
    let ld = document.getElementById('ld')

    if(fd.value == ''){
        fd.style.border = '1px solid red'
        return false
    } else{
        fd.style.border = '1px solid #bfc9d4'
        if(ld.value == ''){
            ld.style.border = '1px solid red'
            return false
        } else{
            ld.style.border = '1px solid #bfc9d4'
            location.replace(url+'?id='+id+'&fd='+fd.value+'&ld='+ld.value)
        }
    }
}
function fillUp(id,value){
    if(document.getElementById('app_version_id').value != id){
        document.getElementById('sendNotificationModalTitle').innerHTML = 'Send notification to users of Version ' + value
        document.getElementById('notificationContent').value = ''
        document.getElementById('app_version_id').value = id
    }
}