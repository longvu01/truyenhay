'use strict';
function Validator(formSelector) {
    // Lấy ra form element trong DOM by `formSelector`
    const formElement = document.querySelector(formSelector)
    // Lưu các rules của form element
    const formRules = {}

    // Quy tắc return
    // return error ? error message : undefined
    const validatorRules = {
        required(value) {
            return value.trim() ? undefined : 'Vui lòng nhập trường này'
        },
        name(value) {
            const regex = /^([A-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪ][a-zàáâãèéêếìíòóôõùúăđĩũơưăạảấầẩẫậắằẳẵặẹẻẽềềểễệỉịọỏốồổỗộớờởỡợụủứừửữựỳỵỷỹ]{1,6}\s?)+$/
            return regex.test(value) ? undefined : 'Vui lòng nhập tên đầy đủ của bạn'
        },
        email(value) {
            const regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
            return regex.test(value) ? undefined : 'Trường này phải là email'
        },
        min(min) {
            return function (value) {
                return value.length >= min ? undefined : `Vui lòng nhập tối thiểu ${min} ký tự`
            }
        },
        max(max) {
            return function (value) {
                return value.length >= max ? undefined : `Vui lòng nhập tối đa ${max} ký tự`
            }
        },
        confirm(confirmName) {
            return function (value) {
                const confirmValue = formElement.querySelector(`input[name = "${confirmName}"]`).value
                return confirmValue === value ? undefined : `Giá trị nhập vào không khớp`
            }
        },
    }

    // Xử lý khi data hợp lệ
    if(formElement) {
        const inputs = formElement.querySelectorAll('[name][rules]')
        for(let input of inputs) {
            const rules = input.getAttribute('rules').split('|');
            for(let rule of rules) {
                let ruleFunc;
                // Nếu rule cần truyền value(min:6, max:100, ...)
                if(rule.includes(':')) {
                    const ruleInfo = rule.split(':')
                    ruleFunc = validatorRules[ruleInfo[0]](ruleInfo[1])
                } 
                // Nếu rule cần truyền confirm(confirm-password, ...)
                else if(rule.includes('-')) {
                    const ruleInfo = rule.split('-')
                    ruleFunc = validatorRules[ruleInfo[0]](ruleInfo[1])
                } else {
                    ruleFunc = validatorRules[rule]
                }

                if(!Array.isArray(formRules[input.name])) {
                    formRules[input.name] = [ruleFunc]
                } else {
                    formRules[input.name].push(ruleFunc)
                }
            }
            // Lắng nghe sự kiện để validate (blur, change, ...)
            input.addEventListener('blur', handleValidate)
            input.addEventListener('input', handleClearError)
        }

        // Hàm thực hiện validate
        function handleValidate(e) {
            const rules = formRules[e.target.name]
            let errorMessage;
            for(let rule of rules) {
                errorMessage = rule(e.target.value)
                if(errorMessage) break;
            }

            // Nếu có lỗi thì hiển thị message lỗi + add class invalid
            const formElement = e.target.closest('.form-group')
            if(formElement) {
                const errorElement = formElement.querySelector('.form-message')
                if(errorElement) {
                    errorMessage ? formElement.classList.add('invalid') : formElement.classList.remove('invalid')
                    errorElement.textContent = errorMessage
                }
            }
            
            return !errorMessage
        }

        // Hàm clear message lỗi, remove class invalid
        function handleClearError(e) {
            const formElement = e.target.closest('.form-group')
            if(formElement) {
                const errorElement = formElement.querySelector('.form-message')
                if(formElement.classList.contains('invalid')) formElement.classList.remove('invalid')
                if(errorElement.textContent) errorElement.textContent = ''
            }
        }

        // Xử lý hành vi submit form
        formElement.addEventListener('submit', (e) => {
            e.preventDefault()
    
            const inputs = formElement.querySelectorAll('[name][rules]')
            // Flag
            let isFormValid = true;
            for(let input of inputs) {
                // Validate với từng input + gán giá trị cho isInvalid
                let isValid = handleValidate({target: input})
                // Kiểm tra
                if (!isValid) {
                    isFormValid = false;
                }
            }

            if(isFormValid) {
                if(this.onSubmit) {
                    const enableInputs = formElement.querySelectorAll('[name]:not([disable])')
                    const formValues = Array.from(enableInputs).reduce((values, input) => {
                        switch(input.type) {
                            case 'radio':
                                const checkedValue = formElement.querySelector(`input[name = "${input.name}"]:checked`)?.value
                                values[input.name] = checkedValue ?? ''
                                break;
                            case 'checkbox':
                                if(input.matches(':checked')) {
                                    if(!Array.isArray(values[input.name])) {
                                        values[input.name] = []
                                    }
                                    values[input.name].push(input.value)
                                } else if(!values[input.name]){
                                    values[input.name] = ''
                                }
                                break;
                            case 'file':
                                values[input.name] = input.files
                                break;
                            default:
                                values[input.name] = input.value
                            }
                        return values
                    }, {})

                    // Gọi lại hàm onSubmit và trả về kèm các giá trị của form
                    this.onSubmit(formValues)
                } else {
                    formElement.submit()
                }
            } else alert('Hãy kiểm tra lại form của bạn 🤬')
        })
    }
}