#!/usr/bin/env node

import { execSync } from 'child_process'
import { existsSync } from 'fs'
import { join } from 'path'

const themes = ['svelte', 'tailwind', 'bootstrap']
const themesDir = 'templates/assets'

console.log('🎨 Building Boson PHP Themes...\n')

for (const theme of themes) {
  const themeDir = join(themesDir, theme)
  
  if (!existsSync(themeDir)) {
    console.log(`❌ Theme directory not found: ${themeDir}`)
    continue
  }
  
  console.log(`📦 Building ${theme} theme...`)
  
  try {
    // Install dependencies if node_modules doesn't exist
    if (!existsSync(join(themeDir, 'node_modules'))) {
      console.log(`   Installing dependencies for ${theme}...`)
      execSync('pnpm install', {
        cwd: themeDir,
        stdio: 'inherit'
      })
    }

    // Build the theme
    console.log(`   Building ${theme} assets...`)
    execSync('pnpm run build', {
      cwd: themeDir,
      stdio: 'inherit'
    })
    
    console.log(`✅ ${theme} theme built successfully\n`)
    
  } catch (error) {
    console.error(`❌ Failed to build ${theme} theme:`, error.message)
    process.exit(1)
  }
}

console.log('🎉 All themes built successfully!')
console.log('\nBuilt assets are available in:')
themes.forEach(theme => {
  console.log(`   - public/assets/${theme}/`)
})

console.log('\n💡 To watch for changes during development:')
console.log('   npm run dev:themes')
