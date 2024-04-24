import Vue from 'vue'
import { AclInstaller, AclCreate, AclRule } from 'vue-acl'
import router from '@/router'

Vue.use(AclInstaller)

let initialRole = 'super_admin'

const userInfo = JSON.parse(localStorage.getItem('userInfo'))
if (userInfo && userInfo.user_type) initialRole = userInfo.user_type

export default new AclCreate({
  initial: initialRole,
  notfound: '/pages/not-authorized',
  router,
  acceptLocalRules: true,
  globalRules: {
    super_admin: new AclRule('super_admin').generate(),
    subadmin: new AclRule('subadmin').generate(),
    accountant: new AclRule('accountant').generate(),
    teacher: new AclRule('teacher').generate(),
    student: new AclRule('student').generate(),
    user: new AclRule('user').generate(),
    editor: new AclRule('super_admin').or('subadmin').or('accountant').or('teacher').or('student').or('user').generate()
  }
})
