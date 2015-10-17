/**
 * Created by gman on 9/21/15.
 */
function configureValidation(f, alerttype) {
            //             f=form;
            var numberForms = f.length;
            var formIndex;
             //for (formIndex = 0; formIndex < numberForms; formIndex++)
             //{
             //alert(f[formIndex].name);
             //}
            var preCheck = preFlight(f);

            return validateForm(f, preCheck, 'required', alerttype);
        }

function preFlight(f) {
    f.email.isEmail = true;
    f.inquiry.optional = false;
    f.keystring.isAlphaNumeric = true;
    f.first.optional = false;
    f.last.optional = true;
}

