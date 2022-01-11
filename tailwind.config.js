module.exports = {
//	mode: 'jit',
	content: ['./themes/components/*.phtml', './themes/layout.phtml', './themes/pages/*.phtml'],
	
	theme: {
		extend: {
			fontFamily: { 
        }
    },
  },
  variants: {
    backgroundColor: ['responsive', 'hover', 'focus', 'active'],
    
  //   display: ({ variants }) => [...variants('display'), 'group-hover'],
  },
  plugins: [],
}
