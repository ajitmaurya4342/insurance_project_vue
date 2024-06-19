import navItems from '@/navigation/vertical'

/* eslint-disable */
// prettier-ignore
export default function () {


  const data = []
  navItems.forEach((item) => {
    if (item.children) {
      item.children.forEach((child) => {
        data.push({
          title: `${item.title} - ${child.title}`, route: { name: child.route }, icon: child.icon, isBookmarked: false
        })
      })
    } else {
      data.push({
        title: item.title, route: { name: item.route }, icon: item.icon, isBookmarked: false
      })
    }
  })

  return {
    pages: {
      key: 'title',
      data
      // [
      //   { title: 'Dashboard', route: { name: 'home' }, icon: 'HomeIcon', isBookmarked: false },
      //   { title: 'Masters', route: { name: 'masters' }, icon: 'GitlabIcon', isBookmarked: false },
      //   { title: 'Movie', route: { name: 'movies' }, icon: 'VideoIcon', isBookmarked: false },
      //   { title: 'Contracts', route: { name: 'contracts' }, icon: 'FileTextIcon', isBookmarked: false },
      //   { title: 'Customers', route: { name: 'contacts' }, icon: 'UserIcon', isBookmarked: false },
      //   { title: 'Upload Revenue', route: { name: 'AddRevenue' }, icon: 'UploadIcon', isBookmarked: false },
      //   { title: 'View Revenue', route: { name: 'ViewRevenue' }, icon: 'CheckSquareIcon', isBookmarked: false },
      //   { title: 'Add Expense', route: { name: 'card-advance' }, icon: 'FolderPlusIcon', isBookmarked: false },
      //   { title: 'View Expense', route: { name: 'card-advance' }, icon: 'InboxIcon', isBookmarked: false },
      //   { title: 'Royalty Report', route: { name: 'card-advance' }, icon: 'BarChart2Icon', isBookmarked: false },
      //   { title: 'Add P&A Budget', route: { name: 'addBudget' }, icon: 'FolderIcon', isBookmarked: false },
      //   { title: 'P&A Budget', route: { name: 'viewBudget' }, icon: 'FolderIcon', isBookmarked: false },
      // ],
    },
  }
}
/* eslint-enable */
