import { CheckIcon, StarIcon, NoSymbolIcon } from "@heroicons/react/24/outline"
import { useEffect, useState } from "react"

function classNames(...classes) {
    return classes.filter(Boolean).join(' ')
}

export default function Tabs({ replies, setData, data }) {

    const [tabs, setTabs] = useState(replies.map((reply) => {
        return {
            value: reply.value,
            name: reply.label,
            icon: getReplyIconByColor(reply.color),
            activeColor: getReplyCssByColor(reply.color),
            current: reply.color === replies[0].color
        }
    }))

    function getReplyCssByColor(color) {
        switch (color) {
            case 'success':
                return 'bg-blue-500 text-white hover:bg-blue-700';
            case 'warning':
                return 'bg-yellow-500 text-white hover:bg-yellow-700';
            case 'danger':
                return 'bg-red-500 text-white hover:bg-red-700';
            default:
                return 'bg-gray-500 text-white hover:bg-gray-700';
        }
    }

    function getReplyIconByColor(color) {
        switch (color) {
            case 'success':
                return CheckIcon;
            case 'warning':
                return StarIcon;
            case 'danger':
                return NoSymbolIcon;
            default:
                return CheckIcon;
        }
    }

    useEffect(() => {
        const updatedTabs = tabs.map(tab => {
            if (tab.value === data.reply) {
                tab.current = true;
            }
            else {
                tab.current = false;
            }
            return tab;
        })
        setTabs(updatedTabs);

    }, [data.reply])


    return (
        <nav className="relative z-0 rounded-lg shadow flex divide-x divide-gray-200" aria-label="Tabs">
            {tabs.map((tab, tabIdx) => (
                <div
                    onClick={(event) => setData('reply', tab.value)}
                    key={tab.value}
                    className={classNames(
                        tab.current ? tab.activeColor : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50',
                        tabIdx === 0 ? 'rounded-l-lg' : '',
                        tabIdx === tabs.length - 1 ? 'rounded-r-lg' : '',
                        'cursor-pointer group relative min-w-0 flex-1 overflow-hidden py-4 px-4 text-sm font-medium text-center focus:z-10'
                    )}
                    aria-current={tab.current ? 'page' : undefined}
                >
                    <tab.icon className="w-5 h-5 mb-1 mx-auto stroke-current" />
                    <span>{tab.name}</span>
                </div>
            ))}
        </nav>
    )
}
