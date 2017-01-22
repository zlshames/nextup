class Storage {
	static getItem(item) {
		if (global.localStorage !== undefined && global.localStorage !== null) {
			return global.localStorage.getItem(item);
		}

		return null
	}

	static setItem(item, value) {
		if (global.localStorage !== undefined && global.localStorage !== null) {
			global.localStorage.setItem(item, value)
		}
	}

	static removeItem(item) {
		if (global.localStorage !== undefined && global.localStorage !== null) {
			if (global.localStorage.getItem(item) !== null) {
				global.localStorage.removeItem(item)
			}
		}
	}
}

module.exports = Storage
