import { toFormValidator } from "@vee-validate/zod";
import * as zod from "zod";

const zodName = () =>
	zod
		.string({ required_error: "هذا الحقل مطلوب" })
		.nonempty("هذا الحقل مطلوب")
		.min(3, { message: "يجب أن يكون الاسم من حرفين على الأقل" });

const zodEmail = () =>
	zod
		.string({ required_error: "هذا الحقل مطلوب" })
		.nonempty("هذا الحقل مطلوب")
		.email({ message: "البريد الإلكتروني غير صحيح" });

const zodProject = () =>
	zod
		.string({ required_error: "هذا الحقل مطلوب" })
		.nonempty("هذا الحقل مطلوب")
		.min(3, { message: "يجب أن يكون اسم المشروع من ثلاثة أحرف على الأقل" });
const zodAbout = () =>
	zod
		.string({ required_error: "هذا الحقل مطلوب" })
		.nonempty("هذا الحقل مطلوب")
		.min(3, { message: "يجب أن يكون النبذة من ثلاثة أحرف على الأقل" });

// Sign Up ZOD Schema
export const firstFormSchema = toFormValidator(
	zod.object({
		name: zodName(),
		email: zodEmail(),
	    project: zodProject(),
	    about: zodAbout(),
	})
);
